<?php

namespace Cosnavel\LaravelQueryLocalization\Tests;

use Cosnavel\LaravelQueryLocalization\LaravelQueryLocalizationServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected $localization;

    protected $locales = [
        'de' => ['name' => 'Deutsch',                 'script' => 'Latn', 'native' => 'Deutsch', 'regional' => 'de_DE', 'flag' => '🇩🇪'],
        'en' => ['name' => 'English',                'script' => 'Latn', 'native' => 'English', 'regional' => 'en_US', 'flag' => '🇺🇸'],
    ];

    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Cosnavel\\LaravelQueryLocalization\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelQueryLocalizationServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');


        $this->localization = $app['laravel-query-localization'];

        $app->setLocale('en');

        $app['config']->set([
            'localization.supportedLocales' => $this->locales,
            'query-localization.useAcceptLanguageHeader' => true,
            'query-localization.useUserLanguagePreference' => true,
        ]);


        /*
        include_once __DIR__.'/../database/migrations/create_laravel-query-localization_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }
}
