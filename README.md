[![Latest Version on Packagist](https://img.shields.io/packagist/v/jalallinux/laravel-setting.svg?style=flat-square)](https://packagist.org/packages/jalallinux/laravel-setting)
[![Tests](https://github.com/jalallinux/laravel-setting/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/jalallinux/laravel-setting/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/jalallinux/laravel-setting.svg?style=flat-square)](https://packagist.org/packages/jalallinux/laravel-setting)
<!--delete-->
---
Use jalallinux/laravel-settings to store key value pair settings in the database.

## Installation

You can install the package via composer:

```bash
composer require jalallinux/laravel-setting
```

## Usage

```php
$skeleton = new JalalLinuX\Setting();
echo $skeleton->echoPhrase('Hello, JalalLinuX!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [JalalLinuX](https://github.com/jalallinux)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
