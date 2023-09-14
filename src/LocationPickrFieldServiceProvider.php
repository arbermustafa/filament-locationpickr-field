<?php

namespace ArberMustafa\FilamentLocationPickrField;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LocationPickrFieldServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-locationpickr-field';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile()
            ->hasAssets()
            ->hasViews();
    }

    public function packageBooted()
    {
        FilamentAsset::register(
            assets: [
                Css::make(static::$name, __DIR__ . '/../resources/dist/filament-locationpickr-field.css'),
                AlpineComponent::make(static::$name, __DIR__ . '/../resources/dist/filament-locationpickr-field.js'),
            ],
            package: 'arbermustafa/filament-locationpickr-field'
        );
    }
}
