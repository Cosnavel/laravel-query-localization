<?php

namespace Cosnavel\LaravelQueryLocalization\Trait;

trait LocaleValidation
{
    /**
     * Returns whether a given locale is supported.
     *
     * @param string $locale
     * @return bool
     */
    protected function isSupportedLocale($locale)
    {
        return in_array($locale, $this->getSupportedLocales());
    }

    /**
     * @return string[]
     */
    protected function getSupportedLocales()
    {
        return $this->getLaravelLocalization()->getSupportedLanguagesKeys();
    }

    /**
     * @return \Cosnavel\LaravelQueryLocalization\LaravelQueryLocalization
     */
    protected function getLaravelQueryLocalization()
    {
        return $this->laravel->make('laravelquerylocalization');
    }

    protected function determineValidLanguage(string $locale)
    {
        $availableLanguages = collect();
        $languages = collect($this->getSupportedLocales());
        foreach ($languages as $key => $language) {
            $language['key'] = $key;
            $availableLanguages->push($language);
        }

        $result = $availableLanguages->first(function ($i, $k) use ($locale) {
            return $locale == $i['key'];
        });

        return $result['key'] ?? 'en';
    }
}
