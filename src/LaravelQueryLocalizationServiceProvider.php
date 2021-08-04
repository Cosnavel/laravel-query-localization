<?php

namespace Cosnavel\LaravelQueryLocalization;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelQueryLocalizationServiceProvider extends PackageServiceProvider
{
    public function registeringPackage()
    {
        $this->app->singleton(LaravelQueryLocalization::class, function () {
            return new LaravelQueryLocalization();
        });

        $this->app->alias(LaravelQueryLocalization::class, 'laravel-query-localization');
    }

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
            ->hasViews()
            ->hasViewComponents('query-localization', [LanguageSelector::class])
            ->hasMigration('add_language_preference_to_users_table');
    }
}
