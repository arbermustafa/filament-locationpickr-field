<?php

namespace ArberMustafa\FilamentLocationPickrField;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class LocationPickrFieldServiceProvider extends PluginServiceProvider
{
    public static string $name = 'filament-locationpickr-field';

    public function configurePackage(Package $package): void
    {
        parent::configurePackage($package);

        $package
            ->name(static::$name)
            ->hasAssets()
            ->hasConfigFile();
    }

    protected function getStyles(): array
    {
        return [
            self::$name . '-styles' => __DIR__ . '/../resources/dist/filament-locationpickr-field.css',
        ];
    }

    protected function getBeforeCoreScripts(): array
    {
        return [
            self::$name . '-scripts' => __DIR__ . '/../resources/dist/filament-locationpickr-field.js',
        ];
    }
}
