<?php

namespace Cosnavel\LaravelQueryLocalization\Middleware;

use Closure;
use Cosnavel\LaravelQueryLocalization\Facades\LaravelQueryLocalization;
use Illuminate\Http\Request;
use TiMacDonald\Middleware\HasParameters;

class LocaleFromRoute
{
    use HasParameters;

    public function handle(Request $request, Closure $next, string $translatedRoute = null)
    {
        if (! session('locale') && $translatedRoute) {
            LaravelQueryLocalization::setLocale($translatedRoute);
        }

        return $next($request);
    }
}
