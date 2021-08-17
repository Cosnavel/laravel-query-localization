<?php

namespace Cosnavel\LaravelQueryLocalization\Middleware;

use Closure;
use Cosnavel\LaravelQueryLocalization\Facades\LaravelQueryLocalization;
use Illuminate\Http\Request;
use TiMacDonald\Middleware\HasParameters;

class LocaleFromQuery
{
    use HasParameters;

    public function handle(Request $request, Closure $next, string $translatedRoute = null)
    {
        if ($request->get('locale')) {
            LaravelQueryLocalization::setLocale($request->get('locale'));

            return $next($request);
        }

        if (! session('locale') && $translatedRoute) {
            LaravelQueryLocalization::setLocale($translatedRoute);

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
