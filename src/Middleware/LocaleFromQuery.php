<?php

namespace Cosnavel\LaravelQueryLocalization\Middleware;

use Closure;
use Illuminate\Http\Request;
use Cosnavel\LaravelQueryLocalization\Facades\LaravelQueryLocalization;

class LocaleFromQuery
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->get('locale')) {
            LaravelQueryLocalization::setLocale($request->get('locale'));

            return $next($request);
        }


        if (LaravelQueryLocalization::getConfigRepository()->get('query-localization.useUserLanguagePreference') && auth()->check()) {
            LaravelQueryLocalization::setLocale(auth()->user()->language_preference);

            return $next($request);
        }

        $locale = LaravelQueryLocalization::getCurrentLocale();
        LaravelQueryLocalization::setLocale($locale);

        return $next($request);
    }
}
