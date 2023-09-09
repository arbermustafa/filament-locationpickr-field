# Filament LocationPickr Field

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

If you want to contribute to this package, you may want to test it in a real Filament project:

-   Fork this repository to your Github account.
-   Create a Filament app locally.
-   Clone your fork in your Filament app root directoy.
-   In the `/filament-locationpickr-field` directory, create a branch for your fix/improvement, e.g. `fix/pickr-field`.

Install the packages in your app's `composer.json`:

```json
"require": {
    "arbermustafa/filament-locationpickr-field": "dev-fix/pickr-field as dev-main",
},
"repositories": [
    {
        "type": "path",
        "url": "./filament-locationpickr-field"
    }
]
```

Now run `composer update`.

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Arber Mustafa](https://github.com/arbermustafa)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
