<?php

namespace Cosnavel\LaravelQueryLocalization\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;

class LocaleSessionRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = session('locale', false);

        if ($locale) {
            return $next($request);
        }


        if ($locale === false) {
            $locale = app('laravel-query-localization')->getCurrentLocale();
        }

        if ($locale && in_array($locale, app('laravel-query-localization')->getSupportedLanguagesKeys())) {
            $queryParams = strpos(url()->previous(), '?');
            if ($queryParams) {
                return redirect(substr(url()->previous(), 0, $queryParams) . "?locale={$locale}");
            }

            return redirect(substr(url()->previous(), 0) . "?locale={$locale}");
        }

        return $next($request);
    }
}
