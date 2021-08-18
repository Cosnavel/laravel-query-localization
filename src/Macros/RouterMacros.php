<?php

namespace Cosnavel\LaravelQueryLocalization\Macros;

use Cosnavel\LaravelQueryLocalization\Facades\LaravelQueryLocalization;
use Cosnavel\LaravelQueryLocalization\Middleware\LocaleFromQuery;

class RouterMacros
{
    public function localize()
    {
        return function (string $routeTranslationKey, $routeName, $action) {
            $translationRoutes = [];
            foreach (LaravelQueryLocalization::getSupportedLanguagesKeys() as $lang) {
                $translationRoutes[$lang] = trans($routeTranslationKey, [], $lang);
            }

            return $this->group([], function () use ($translationRoutes, $action, $routeName) {
                foreach ($translationRoutes as $language => $translatedRoute) {
                    $this->group([
                        'prefix' => $translatedRoute, 'middleware' => LocaleFromQuery::with([
                            'translatedRoute' => $language,
                        ]),
                    ], function () use ($action, $routeName) {
                        $this->get('/', $action)->name($routeName);
                    });
                }
            });
        };
    }
}
