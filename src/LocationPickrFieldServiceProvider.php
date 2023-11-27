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
                Css::make('locationpickr', __DIR__ . '/../resources/dist/locationpickr.css')->loadedOnRequest(),
                AlpineComponent::make('locationpickr-field', __DIR__ . '/../resources/dist/field.js'),
                AlpineComponent::make('locationpickr-entry', __DIR__ . '/../resources/dist/entry.js'),
            ],
            package: 'arbermustafa/filament-locationpickr-field'
        );
    }
}
