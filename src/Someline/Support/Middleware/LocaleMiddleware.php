<?php

namespace Someline\Support\Middleware;

use Carbon\Carbon;
use Closure;
use LaravelLocalization;
use Mcamara\LaravelLocalization\LanguageNegotiator;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // get current locale
        $locale = LaravelLocalization::getCurrentLocale();

        // set locale
        LaravelLocalization::setLocale($locale);

        // set carbon locale
        Carbon::setLocale($locale);

        return $next($request);
    }

}
