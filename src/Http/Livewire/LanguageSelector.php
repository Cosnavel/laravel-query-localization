<?php

namespace Cosnavel\LaravelQueryLocalization\Http\Livewire;

use Livewire\Component;

use Cosnavel\LaravelQueryLocalization\Trait\AttributesMergeable;

class LanguageSelector extends Component
{
    use AttributesMergeable;

    public $activeLanguage;
    public $languages;

    public function mount()
    {
        $this->languages = collect();
        $languages = collect(LaravelLocalization::getSupportedLocales());
        foreach ($languages as $key => $language) {
            $language['key'] = $key;
            $this->languages->push($language);
        }
        $this->activeLanguage = $this->languages->where('key', session('locale'))->keys()->first();
    }

    public function updatedActiveLanguage($value)
    {
        $locale = $this->languages->first(fn ($i, $k) => $value == $k)['key'];

        $this->changeAuthUserLanguagePreference($locale);
        $this->locale = $locale;

        $queryParams = strpos(url()->previous(), '?');
        if ($queryParams) {
            return redirect(substr(url()->previous(), 0, $queryParams) . "?locale={$locale}");
        }

        return redirect(substr(url()->previous(), 0) . "?locale={$locale}");
    }

    private function changeAuthUserLanguagePreference(string $locale): void
    {
        if (auth()->check()) {
            auth()->user()->language_preference = $locale;
            auth()->user()->save();
        }
    }

    public function render()
    {
        return view('livewire.language-selector');
    }
}
