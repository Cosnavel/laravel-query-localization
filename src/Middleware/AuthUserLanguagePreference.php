<?php

namespace Cosnavel\LaravelQueryLocalization\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class AuthUserLanguagePreference
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            session(['locale' => auth()->user()->language_preference]);
        }

        App::setlocale(session()->get('locale'));

        return $next($request);
    }
}
