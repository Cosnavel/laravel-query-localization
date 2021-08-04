<?php

namespace Cosnavel\LaravelQueryLocalization;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Cosnavel\LaravelQueryLocalization\LaravelQueryLocalization
 */
class LaravelQueryLocalizationFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-query-localization';
    }
}
