<?php

namespace Cosnavel\LaravelQueryLocalization;

use Illuminate\Http\Request;

class LanguageNegotiator
{
    protected \Illuminate\Config\Repository $configRepository;


    protected \Illuminate\Foundation\Application $app;

    private string $defaultLocale;

    private array $supportedLanguages;

    private \Illuminate\Http\Request $request;

    public function __construct(string $defaultLocale, array $supportedLanguages, Request $request)
    {
        $this->app = app();
        $this->configRepository = $this->app['config'];
        $this->defaultLocale = $defaultLocale;
        $this->supportedLanguages = $supportedLanguages;
        $this->request = $request;
    }

    /**
     * Negotiates language with the user's browser through the Accept-Language
     * HTTP header or the user's host address.
     *
     * This function is based on negotiateLanguage from Pear HTTP2
     * http://pear.php.net/package/HTTP2/
     */
    public function negotiateLanguage(): string
    {
        $matches = $this->getMatchesFromAcceptedLanguages();
        foreach ($matches as $key => $q) {
            if (! empty($this->supportedLanguages[$key])) {
                return $key;
            }
            foreach ($this->supportedLanguages as $key_supported => $locale) {
                if ((isset($locale['regional']) && $locale['regional'] == $key) || (isset($locale['lang']) && $locale['lang'] == $key)) {
                    return $key_supported;
                }
            }
        }
        if (isset($matches['*'])) {
            reset($this->supportedLanguages);

            return key($this->supportedLanguages);
        }
        if ($this->request->server('REMOTE_HOST')) {
            $remote_host = explode('.', $this->request->server('REMOTE_HOST'));
            $lang = strtolower(end($remote_host));
            if (! empty($this->supportedLanguages[$lang])) {
                return $lang;
            }
        }

        return $this->defaultLocale;
    }

    /**
     * Return all the accepted languages from the browser.
     */
    private function getMatchesFromAcceptedLanguages(): array
    {
        $matches = [];
        if ($acceptLanguages = $this->request->header('Accept-Language')) {
            $acceptLanguages = explode(',', $acceptLanguages);
            $generic_matches = [];
            foreach ($acceptLanguages as $option) {
                $option = array_map('trim', explode(';', $option));
                $l = $option[0];
                if (isset($option[1])) {
                    $q = (float)str_replace('q=', '', $option[1]);
                } else {
                    $q = null;
                    // Assign default low weight for generic values
                    if ($l == '*/*') {
                        $q = 0.01;
                    } elseif (substr($l, -1) == '*') {
                        $q = 0.02;
                    }
                }
                // Unweighted values, get high weight by their position in the list
                $q = $q ?? 1000 - \count($matches);
                $matches[$l] = $q;
                //If for some reason the Accept-Language header only sends language with country
                //we should make the language without country an accepted option, with a value
                //less than it's parent.
                $l_ops = explode('-', $l);
                array_pop($l_ops);
                while (! empty($l_ops)) {
                    //The new generic option needs to be slightly less important than it's base
                    $q -= 0.001;
                    $op = implode('-', $l_ops);
                    if (empty($generic_matches[$op]) || $generic_matches[$op] > $q) {
                        $generic_matches[$op] = $q;
                    }
                    array_pop($l_ops);
                }
            }
            $matches = array_merge($generic_matches, $matches);
            arsort($matches, SORT_NUMERIC);
        }

        return $matches;
    }
}
