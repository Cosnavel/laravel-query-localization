<?php

namespace Cosnavel\LaravelQueryLocalization;

use Cosnavel\LaravelQueryLocalization\Http\Livewire\LanguageSelector;
use Cosnavel\LaravelQueryLocalization\Macros\RouterMacros;
use Illuminate\Routing\Router;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelQueryLocalizationServiceProvider extends PackageServiceProvider
{
    public function bootingPackage()
    {
        if (class_exists(Livewire::class)) {
            Livewire::component('language-selector', LanguageSelector::class);
        }
        Router::mixin(new RouterMacros());
    }

    public function packageRegistered()
    {
        $this->app->singleton(LaravelQueryLocalization::class, function () {
            return new LaravelQueryLocalization();
        });

        $this->app->alias(LaravelQueryLocalization::class, 'laravel-query-localization');
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-query-localization')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('add_language_preference_to_users_table');
    }
}
