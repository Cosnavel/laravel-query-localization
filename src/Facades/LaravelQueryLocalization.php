<?php

namespace Cosnavel\LaravelQueryLocalization\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @package Cosnavel\LaravelQueryLocalization\Facades
 */
class LaravelQueryLocalization extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-query-localization';
    }
}
