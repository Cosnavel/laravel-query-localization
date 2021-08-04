<?php

namespace Cosnavel\LaravelQueryLocalization;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Cosnavel\LaravelQueryLocalization\Commands\LaravelQueryLocalizationCommand;

class LaravelQueryLocalizationServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-query-localization')
            ->hasConfigFile()
            ->hasViewComponents('query-localization', [LanguageSelector::class])
            ->hasMigration('add_language_preference_to_users_table');
    }
}
