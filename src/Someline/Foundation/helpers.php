<?php

if (!function_exists('current_auth_user')) {

    /**
     * @param bool $throwException
     * @return \Someline\Model\Foundation\User
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    function current_auth_user($throwException = true)
    {
        $user = app('Dingo\Api\Auth\Auth')->user(false);
        $user = !empty($user) ? $user : \Auth::user();
        if (!$user || !($user instanceof \Someline\Model\Foundation\User)) {
            if ($throwException) {
                throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
            }
        }
        return $user;
    }

}

if (!function_exists('auth_check')) {

    /**
     * @return boolean
     */
    function auth_check()
    {
        return \Auth::check();
    }

}

if (!function_exists('current_full_url')) {

    function current_full_url($withQueryString = true)
    {
        $url = \Request::url();
        $query = $withQueryString ? (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null) : null;

        if ($query) {
            $path = \Request::path();
            if (starts_with($query, $path . '&')) {
                $query = substr($query, strlen($path) + 1);
            } else if (starts_with($query, $path)) {
                $query = substr($query, strlen($path));
            }
        }

        $url = $query ? $url . '?' . $query : $url;
        return $url;
    }

}

if (!function_exists('smart_get_client_ip')) {

    /**
     * @return array|string
     */
    function smart_get_client_ip()
    {
        $request = request();
        $clientIp = $request->header('X-Client-Ip');
        if (empty($clientIp)) {
            $clientIp = $request->getClientIp(true);
        }
        return $clientIp;
    }

}

if (!function_exists('app_locale')) {

    function app_locale()
    {
        return \App::getLocale();
    }

}

if (!function_exists('app_timezone')) {

    /**
     * @return mixed
     */
    function app_timezone()
    {
        return \Config::get("app.timezone");
    }

}

if (!function_exists('jwt_token')) {

    /**
     * @return string|null
     */
    function jwt_token()
    {
        $jwt_token = \Session::get('jwt_token');
        if (is_jwt_token_valid_for_refresh($jwt_token, true)
            || (empty($jwt_token) && \Auth::check())
        ) {
            $refreshed_token = refresh_jwt_token();
            if (!empty($refreshed_token)) {
                $jwt_token = $refreshed_token;
            }
        }
        return $jwt_token;
    }

}

if (!function_exists('refresh_jwt_token')) {

    /**
     * @return string|null
     */
    function refresh_jwt_token()
    {
        $jwt_token = null;
        if (\Auth::check()) {
            $jwt_token = \JWTAuth::fromUser(current_auth_user());
            \Session::put('jwt_token', $jwt_token);
        }
        return $jwt_token;
    }

}

if (!function_exists('is_jwt_token_valid_for_refresh')) {

    /**
     * @param $token
     * @param bool $allowExpireRefresh
     * @return bool
     */
    function is_jwt_token_valid_for_refresh($token, $allowExpireRefresh = false)
    {
        $is_jwt_token_valid_for_refresh = false;
        try {
            $payload = \JWTAuth::getPayload($token);
            $exp = $payload->get('exp');
            $nbf = $payload->get('nbf');
            if ($exp > 0 && $nbf > 0) {
                $nowTime = \Carbon\Carbon::now('UTC');
                $expireTime = \Carbon\Carbon::createFromTimestampUTC($exp);
                $validTime = \Carbon\Carbon::createFromTimestampUTC($nbf);

                // if now time is after valid time
                if ($nowTime->gt($validTime)) {
                    $minutesAfterValid = $nowTime->diffInMinutes($validTime);
                    $minutesBeforeExpire = $nowTime->diffInMinutes($expireTime);
                    $totalValidLength = $validTime->diffInMinutes($expireTime);
                    $halfAmountOfMinutes = floor($totalValidLength / 2);
                    if ($minutesAfterValid >= $halfAmountOfMinutes) {
                        $is_jwt_token_valid_for_refresh = true;
                    }
                }
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            if ($allowExpireRefresh) {
                $is_jwt_token_valid_for_refresh = true;
            }
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
        }
        return $is_jwt_token_valid_for_refresh;
    }

}

if (!function_exists('phone_parse')) {

    /**
     * @param string $phone_number
     * @param string $country_code An ISO 3166-1 two letter country code
     * @return null|\libphonenumber\PhoneNumber
     */
    function phone_parse($phone_number, $country_code)
    {
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        try {
            $phoneNumberProto = $phoneUtil->parseAndKeepRawInput($phone_number, $country_code);
            return $phoneNumberProto;
        } catch (\libphonenumber\NumberParseException $e) {
            return null;
        }
    }

}

if (!function_exists('phone_model_from')) {

    /**
     * @param string $phone_number
     * @param string $country_code An ISO 3166-1 two letter country code
     * @return \Someline\Model\Basic\PhoneNumberModel
     */
    function phone_model_from($phone_number, $country_code)
    {
        return new \Someline\Model\Basic\PhoneNumberModel($phone_number, $country_code);
    }

}

if (!function_exists('ip_to_country_iso_code')) {

    function ip_to_country_iso_code($ip = null, $default_iso_code = 'US')
    {
        if (empty($ip)) {
            $ip = smart_get_client_ip();
        }

        $location = \GeoIP::getLocation($ip);

        // check if NOT returned default
        if ($location['default'] === false && !empty($location['iso_code'])) {
            return $location['iso_code'];
        } else if ($location['default'] === false && !empty($location['isoCode'])) {
            return $location['isoCode'];
        } else {
            return $default_iso_code;
        }
    }

}

if (!function_exists('collection_paginate')) {

    /**
     * @param \Illuminate\Support\Collection $collection
     * @param $perPage
     * @param string $pageName
     * @param null $page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    function collection_paginate(\Illuminate\Support\Collection $collection, $perPage, $pageName = 'page', $page = null)
    {
        $page = $page ?: \Illuminate\Pagination\Paginator::resolveCurrentPage($pageName);

        $results = $collection->forPage($page, $perPage);

        parse_str(request()->getQueryString(), $query);
        unset($query[$pageName]);

        return new \Illuminate\Pagination\LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
                'pageName' => $pageName,
                'path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath(),
                'query' => $query,
            ]
        );
    }

}

if (!function_exists('str_contains_ascii_only')) {

    function str_contains_ascii_only($string)
    {
        return (preg_match('%^[ -~]+$%', $string, $m));
    }

}

if (!function_exists('in_arrayi')) {

    function in_arrayi($needle, $haystack)
    {
        return in_array(strtolower($needle), array_map('strtolower', $haystack));
    }

}