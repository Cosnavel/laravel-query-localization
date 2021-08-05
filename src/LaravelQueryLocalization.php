<?php

namespace Cosnavel\LaravelQueryLocalization;

use Cosnavel\LaravelQueryLocalization\Trait\LocaleValidation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

class LaravelQueryLocalization
{
    use LocaleValidation;

    protected \Illuminate\Foundation\Application $app;

    protected $request;

    protected $currentLocale = false;

    protected $configRepository;

    protected $defaultLocale;

    /**
     * Creates new instance.
     */
    public function __construct()
    {
        $this->app = app();

        $this->configRepository = $this->app['config'];
        $this->request = $this->app['request'];

        // set default locale
        $this->defaultLocale = $this->configRepository->get('app.locale');
        $supportedLocales = $this->getSupportedLocales();

        if (empty($supportedLocales[$this->defaultLocale])) {
            //Todo use custom exception
            throw new \Exception('Laravel default locale is not in the supportedLocales array.');
        }
    }

    /**
     * Returns the translation key for a given path.
     *
     * @return bool Returns value of useAcceptLanguageHeader in config.
     */
    protected function useAcceptLanguageHeader()
    {
        return $this->configRepository->get('query-localization.useAcceptLanguageHeader');
    }

    /**
     * Returns supported languages language key.
     *
     * @return array keys of supported languages
     */
    public function getSupportedLanguagesKeys()
    {
        return array_keys($this->supportedLocales);
    }

    /**
     *
     * @param mixed|null $locale
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function setLocale($locale = null): void
    {
        $locale = $this->determineValidLanguage($locale);


        session(['locale' => $locale]);


        $this->currentLocale = $locale;

        App::setlocale($locale);

        return;
    }

    /**
     * Returns current language.
     *
     * @return string current language
     */
    public function getCurrentLocale()
    {
        if ($this->currentLocale) {
            return $this->currentLocale;
        }

        if (session()->has('locale')) {
            return session('locale');
        }

        if ($this->useAcceptLanguageHeader() && ! $this->app->runningInConsole()) {
            $negotiator = new LanguageNegotiator($this->defaultLocale, $this->getSupportedLocales(), $this->request);

            return $negotiator->negotiateLanguage();
        }

        return $this->configRepository->get('app.locale');
    }

    /**
     * Return an array of all supported Locales.
     *
     * @throws SupportedLocalesNotDefined
     *
     * @return array
     */
    public function getSupportedLocales()
    {
        if (! empty($this->supportedLocales)) {
            return $this->supportedLocales;
        }

        $locales = $this->configRepository->get('query-localization.supportedLocales');

        if (empty($locales) || ! \is_array($locales)) {
            //Todo use custom exception
            throw new \Exception();
        }

        $this->supportedLocales = $locales;

        return $locales;
    }

    public function setUserLanguagePreference($locale): void
    {
        if (! Schema::hasColumn('users', 'language_preference')) {
            //Todo use custom exception
            throw new \Exception();
        }

        if ($this->configRepository->get('query-localization.useUserLanguagePreference') && auth()->check()) {
            $locale = $this->determineValidLanguage($locale);

            auth()->user()->language_preference = $locale;
            auth()->user()->save();
        }
    }

    /**
     * Returns the config repository for this instance.
     *
     * @return Repository Configuration repository
     */
    public function getConfigRepository()
    {
        return $this->configRepository;
    }
}
