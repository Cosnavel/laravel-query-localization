<?php

namespace Cosnavel\LaravelQueryLocalization\Traits;

trait LocaleValidation
{
    public function determineValidLanguage(string $locale): string
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

        return $result['key'] ?? $this->defaultLocale;
    }
}
