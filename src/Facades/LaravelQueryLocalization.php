<?php

namespace Cosnavel\LaravelQueryLocalization\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Cosnavel\LaravelQueryLocalization\LaravelQueryLocalization
 */
class LaravelQueryLocalization extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-query-localization';
    }
}
