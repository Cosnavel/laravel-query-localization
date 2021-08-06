<?php

namespace Cosnavel\LaravelQueryLocalization;

use Cosnavel\LaravelQueryLocalization\Exceptions\LanguagePreferenceException;
use Cosnavel\LaravelQueryLocalization\Exceptions\SupportedLocalesNotDefined;
use Cosnavel\LaravelQueryLocalization\Exceptions\UnsupportedLocaleException;
use Cosnavel\LaravelQueryLocalization\Traits\LocaleValidation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

class LaravelQueryLocalization
{
    use LocaleValidation;

    protected \Illuminate\Foundation\Application $app;

    protected $request;

    protected string | bool $currentLocale = false;

    protected \Illuminate\Config\Repository $configRepository;

    protected string $defaultLocale;

    public function __construct()
    {
        $this->app = app();

        $this->configRepository = $this->app['config'];
        $this->request = $this->app['request'];

        $this->defaultLocale = $this->configRepository->get('app.locale');
        $supportedLocales = $this->getSupportedLocales();

        if (empty($supportedLocales[$this->defaultLocale])) {
            throw new UnsupportedLocaleException('Laravel default locale is not in the supportedLocales array.');
        }
    }

    /**
     * Returns the translation key for a given path.
     *
     * @return bool Returns value of useAcceptLanguageHeader in config.
     */
    protected function useAcceptLanguageHeader(): bool
    {
        return $this->configRepository->get('query-localization.useAcceptLanguageHeader');
    }

    /**
     * Returns supported languages language key.
     *
     * @return array keys of supported languages
     */
    public function getSupportedLanguagesKeys(): array
    {
        return array_keys($this->supportedLocales);
    }

    /**
     * Set valid locale
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function setLocale(string | null $locale = null): void
    {
        $locale = $this->determineValidLanguage($locale);

        session(['locale' => $locale]);

        $this->currentLocale = $locale;

        App::setlocale($locale);

        return;
    }

    /**
     * Returns current language.
     * return the current locale from session or singleton attribute
     * if none found negotiates locale from acceptLanguageHeaders.
     * when acceptLanguageHeaders is disabled and no value is availabe in the session,
     * use default locale
     */
    public function getCurrentLocale(): string
    {
        if ($this->currentLocale) {
            return $this->currentLocale;
        }

        if (session()->has('locale')) {
            return session('locale');
        }

        if ($this->useAcceptLanguageHeader() && !$this->app->runningInConsole()) {
            $negotiator = new LanguageNegotiator($this->defaultLocale, $this->getSupportedLocales(), $this->request);

            return $negotiator->negotiateLanguage();
        }

        return $this->configRepository->get('app.locale');
    }

    /**
     * Return an array of all supported Locales.
     */
    public function getSupportedLocales(): array
    {
        if (!empty($this->supportedLocales)) {
            return $this->supportedLocales;
        }

        $locales = $this->configRepository->get('query-localization.supportedLocales');

        if (empty($locales) || !\is_array($locales)) {
            throw new SupportedLocalesNotDefined();
        }

        $this->supportedLocales = $locales;

        return $locales;
    }

    public function setUserLanguagePreference(string $locale): void
    {
        if (!Schema::hasColumn('users', 'language_preference')) {
            throw new LanguagePreferenceException();
        }

        if ($this->configRepository->get('query-localization.useUserLanguagePreference') && auth()->check()) {
            $locale = $this->determineValidLanguage($locale);

            auth()->user()->language_preference = $locale;
            auth()->user()->save();
        }
    }

    /**
     * Returns the config repository for this instance.
     */
    public function getConfigRepository(): \Illuminate\Config\Repository
    {
        return $this->configRepository;
    }
}
