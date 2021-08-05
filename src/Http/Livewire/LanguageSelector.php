<?php

namespace Cosnavel\LaravelQueryLocalization\Http\Livewire;

use Cosnavel\LaravelQueryLocalization\Facades\LaravelQueryLocalization;
use Cosnavel\LaravelQueryLocalization\Trait\AttributesMergeable;

use Livewire\Component;

class LanguageSelector extends Component
{
    use AttributesMergeable;

    public $activeLanguage;
    public $languages;

    public function mount()
    {
        $this->languages = collect();
        $languages = collect(LaravelQueryLocalization::getSupportedLocales());
        foreach ($languages as $key => $language) {
            $language['key'] = $key;
            $this->languages->push($language);
        }
        $this->activeLanguage = $this->languages->where('key', LaravelQueryLocalization::getCurrentLocale())->keys()->first();
    }

    public function updatedActiveLanguage($value)
    {
        $locale = $this->languages->first(fn ($i, $k) => $value == $k)['key'];

        LaravelQueryLocalization::setUserLanguagePreference($locale);
        $this->locale = $locale;

        $queryParams = strpos(url()->previous(), '?');
        if ($queryParams) {
            return redirect(substr(url()->previous(), 0, $queryParams) . "?locale={$locale}");
        }

        return redirect(substr(url()->previous(), 0) . "?locale={$locale}");
    }

    public function render()
    {
        return view('query-localization::language-selector');
    }
}
