![laravel-package_2](https://user-images.githubusercontent.com/42392570/128426801-fe9ad4cc-1063-4fb3-9e0e-62a5e9dfaaf2.png)
# Query String Localization Package for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/cosnavel/laravel-query-localization.svg?style=flat-square)](https://packagist.org/packages/cosnavel/laravel-query-localization)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/cosnavel/laravel-query-localization/run-tests?label=tests)](https://github.com/cosnavel/laravel-query-localization/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/cosnavel/laravel-query-localization/Check%20&%20fix%20styling?label=code%20style)](https://github.com/cosnavel/laravel-query-localization/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/cosnavel/laravel-query-localization.svg?style=flat-square)](https://packagist.org/packages/cosnavel/laravel-query-localization)

---

Use this package to localize your laravel application via query strings easily.

### Features:

- Localization based on a query string.
- Includes a Livewire language selector component.
- Optionally stores the user language preference to the user's table and apply it for every session.


---

## Installation

To get started, require the package via composer:

```bash
composer require cosnavel/laravel-query-localization
```


### Config File

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Cosnavel\LaravelQueryLocalization\LaravelQueryLocalizationServiceProvider" --tag="laravel-query-localization-config"
```

After publishing, *config query-localization.php* will be created.

The configuration options are:

- **supportedLocales** Languages of your app (Default: English & German).

- **useAcceptLanguageHeader** If true, then automatically detect language from browser.


- **useUserLanguagePreference** If true, save the language preference of an authenticated user in the database and apply the preference on each session

## Usage

### Register Middleware

To get started, register the LocaleFromQuery middleware for the Route Group that needs to be localized.

```php
// routes/web.php


Route::middleware(LocaleFromQuery::class)->group(function () {
    Route::view('/', 'welcome');
});
```


### User Language Preference


If you want to save the language preference to the users table:

- publish the config file
- enable ```useLanguageUserPreference``` in the config file
- publish and run the migrations

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Cosnavel\LaravelQueryLocalization\LaravelQueryLocalizationServiceProvider" --tag="laravel-query-localization-migrations"
php artisan migrate
```

- if you want to use mass assignment for the ```language_preference``` field in the users table make the field fillable in the user model



## Helpers

### Get Supported Locales

Return all supported locales and their properties as an array.

```php
Cosnavel\LaravelQueryLocalization\Facades\LaravelQueryLocalization::getSupportedLocales();
```

### Get Current Locale

Return the key of the current locale.
- Return the current locale from the session
- if none found, it negotiates locale from acceptLanguageHeaders.
- when acceptLanguageHeaders option is disabled, and no value is available in the session, use the applications default locale

```php
Cosnavel\LaravelQueryLocalization\Facades\LaravelQueryLocalization::getCurrentLocale();
```

### Determine Valid Locales

Checks if the passed locale is a supportedLocale (check the config to add your needed locales). If it is not, the returned locale is the application's default locale.

```php
Cosnavel\LaravelQueryLocalization\Facades\LaravelQueryLocalization::determineValidLanguage('en');
```

### Set Locale

Set locale programmatically. Internally the passed locale gets determined if it's a valid locale.

```php
Cosnavel\LaravelQueryLocalization\Facades\LaravelQueryLocalization::setLocale('en');
```
### Set User Language Preference

Set an authed user's language preference. The passed language will also be checked for availability.

```php
Cosnavel\LaravelQueryLocalization\Facades\LaravelQueryLocalization::setUserLanguagePreference('en');
```



## Language Selector

If you're supporting multiple locales in your project, you will probably want to provide the users with a way to change the language.

Included in this package is a language selector. The Language Selector is built with Tailwind, Alpine & Livewire.




https://user-images.githubusercontent.com/42392570/128573314-2fe1d2a8-1743-4533-8778-65009c957232.mp4





### Alpine
The Language Picker requires Alpine. You can use the official CDN to quickly include Alpine:

```html
<!-- Alpine v2 -->
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

<!-- Alpine v3 -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

```

### Usage

Just include the Livewire Component in your blade view. All available locales from your config will be used.

 ```blade
 @livewire('language-selector')
 ```
 When *useUserLanguagePreference* is enabled, the language preference of an authenticated user will be set.


If you don't want to use Tailwind or want to customize the language picker, I recommend that you publish the component the markup as you like.

```bash

php artisan vendor:publish --provider="Cosnavel\LaravelQueryLocalization\LaravelQueryLocalizationServiceProvider" --tag="laravel-query-localization-views"

```


## Testing

```bash
composer test
```


## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Credits

- [Cosnavel](https://github.com/Cosnavel)
- [Rheamars](https://github.com/Rheamars)
- [Lotti](https://twitter.com/CharlotteZaspel) Thanks for the artwork
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
