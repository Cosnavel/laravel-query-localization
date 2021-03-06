<?php

return [
    // Uncomment the languages that your site supports - or add new ones.
    'supportedLocales' => [

        //'da'          => ['name' => 'Danish',                 'script' => 'Latn', 'native' => 'dansk', 'regional' => 'da_DK', 'flag' => 'ð©ð°'],

        'de'          => ['name' => 'Deutsch',                 'script' => 'Latn', 'native' => 'Deutsch', 'regional' => 'de_DE', 'flag' => 'ð©ðª'],
        'en'          => ['name' => 'English',                'script' => 'Latn', 'native' => 'English', 'regional' => 'en_US', 'flag' => 'ðºð¸'],
        // 'es'          => ['name' => 'Spanish',                'script' => 'Latn', 'native' => 'espaÃ±ol', 'regional' => 'es_ES', 'flag' => 'ðªð¸'],
        // 'fr'          => ['name' => 'French',                'script' => 'Latn', 'native' => 'franÃ§ais', 'regional' => 'fr_FR', 'flag' => 'ð«ð·'],
        //'it'          => ['name' => 'Italian',                'script' => 'Latn', 'native' => 'italiano', 'regional' => 'it_IT', 'flag' => 'ð®ð¹'],

        //'nl'          => ['name' => 'Dutch',                  'script' => 'Latn', 'native' => 'Nederlands', 'regional' => 'nl_NL', 'flag' => 'ð³ð±'],

        //'sv'          => ['name' => 'Swedish',                'script' => 'Latn', 'native' => 'svenska', 'regional' => 'sv_SE', 'flag' => 'ð¸ðª'],
        // 'ru'          => ['name' => 'Russian',                'script' => 'Cyrl', 'native' => 'ÑÑÑÑÐºÐ¸Ð¹', 'regional' => 'ru_RU', 'flag' => 'ð·ðº'],
        // 'ja'          => ['name' => 'Japanese',                'script' => 'Jpan', 'native' => 'æ¥æ¬èª', 'regional' => 'ja_JP', 'flag' => 'ð¯ðµ'],
        // 'zh'          => ['name' => 'Chinese (Simplified)',                'script' => 'Hans', 'native' => 'ç®ä½ä¸­æ', 'regional' => 'zh_CN', 'flag' => 'ð¨ð³'],
    ],

    // Automatically determine locale from browser (https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Accept-Language)
    // on first call if it's not defined in the URL. Redirect user to computed localized url.
    //
    // The locale will be stored in session and only be computed from browser
    // again if the session expires.
    //
    // If false, system will take app.php locale attribute

    'useAcceptLanguageHeader' => true,


    // Save the language preferences for an authenticated user in the database.
    // Apply this preference for the auth user for every session.
    'useUserLanguagePreference' => true,
];
