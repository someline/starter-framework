<?php

namespace Someline\Support\Middleware;

use Carbon\Carbon;
use Closure;
use LaravelLocalization;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // get supported locales
        $supportedLocales = LaravelLocalization::getSupportedLocales();

        // 1. get current locale
        $locale = LaravelLocalization::getCurrentLocale();

        // 2. check from session
        $sessionLocale = session('someline-locale');
        if (!empty($sessionLocale)) {
            // if supported
            if (is_array($supportedLocales) && isset($supportedLocales[$sessionLocale])) {
                $locale = $sessionLocale;
            }
        }

        // 3. check from lang
        $lang = $request->get('lang');
        if (!empty($lang)) {
            // if supported
            if (is_array($supportedLocales) && isset($supportedLocales[$lang])) {
                $locale = $lang;
            }
        }

        // set locale
        LaravelLocalization::setLocale($locale);

        // set carbon locale
        Carbon::setLocale($locale);

        return $next($request);
    }

}
