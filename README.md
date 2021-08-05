# Query String Localization Package for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/cosnavel/laravel-query-localization.svg?style=flat-square)](https://packagist.org/packages/cosnavel/laravel-query-localization)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/cosnavel/laravel-query-localization/run-tests?label=tests)](https://github.com/cosnavel/laravel-query-localization/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/cosnavel/laravel-query-localization/Check%20&%20fix%20styling?label=code%20style)](https://github.com/cosnavel/laravel-query-localization/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/cosnavel/laravel-query-localization.svg?style=flat-square)](https://packagist.org/packages/cosnavel/laravel-query-localization)

---

Use this package to localize your application. 

###Features:

- Localization based on a query string.
- Includes a Livewire language selector component.
- Optionally stores the user language preference to the users table.

###Requirements:

- Laravel 8
- Livewire 2
- Tailwind 2
- AlpineJs 2

---

## Installation

You can install the package via composer:

```bash
composer require cosnavel/laravel-query-localization
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Cosnavel\LaravelQueryLocalization\LaravelQueryLocalizationServiceProvider" --tag="laravel-query-localization-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Cosnavel\LaravelQueryLocalization\LaravelQueryLocalizationServiceProvider" --tag="laravel-query-localization-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

### Language Preference

If you want to save the language preference to the users table:

- publish the config file
- enable ```useLanguageUserPreference``` in the config file
- publish and run the migrations
- if you want to use mass assignment for the ```language_preference``` field in the users table add the field to the fillables of the user model

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Cosnavel](https://github.com/Cosnavel)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
