<?php

namespace Cosnavel\LaravelQueryLocalization\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Cosnavel\LaravelQueryLocalization\Trait\LocaleValidation;

class LocaleFromQuery
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->get('locale')) {
            app('laravel-query-localization')->setLocale($request->get('locale'));
        }
        dump(app('laravel-query-localization'));
        dump(session('locale'));

        return $next($request);
    }
}
