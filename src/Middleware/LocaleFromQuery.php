<?php

namespace Cosnavel\LaravelQueryLocalization\Middleware;

use Closure;
use Cosnavel\LaravelQueryLocalization\Trait\LocaleValidation;
use Illuminate\Support\Facades\App;

class LocaleFromQuery
{
    use LocaleValidation;

    public function handle(Request $request, Closure $next)
    {
        if ($request->get('locale')) {
            session(['locale' => $this->determineValidLanguage($request->get('locale'))]);
        }

        if (! session()->has('locale')) {
            session(['locale' => config('app.locale', 'en')]);
        }

        App::setlocale(session()->get('locale'));

        return $next($request);
    }
}
