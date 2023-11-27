<?php

namespace ArberMustafa\FilamentLocationPickrField\Infolists\Components;

use Closure;
use Filament\Infolists\Components\Entry;

class LocationPickr extends Entry
{
    protected string $view = 'filament-locationpickr-field::infolists.components.locationpickr';

    protected array | Closure | null $defaultLocation = [0, 0];

    protected int | Closure $defaultZoom = 8;

    protected string | Closure $height = '400px';

    public function defaultLocation(array | Closure $defaultLocation): static
    {
        $this->defaultLocation = $defaultLocation;

        return $this;
    }

    public function getDefaultLocation(): array
    {
        $position = $this->evaluate($this->defaultLocation);

        if (is_array($position)) {
            if (array_key_exists('lat', $position) && array_key_exists('lng', $position)) {
                return $position;
            } elseif (is_numeric($position[0]) && is_numeric($position[1])) {
                return [
                    'lat' => is_string($position[0]) ? round(floatval($position[0]), $this->precision) : $position[0],
                    'lng' => is_string($position[1]) ? round(floatval($position[1]), $this->precision) : $position[1],
                ];
            }
        }

        return config('filament-locationpickr-field.default_location');
    }

    public function defaultZoom(int | Closure $defaultZoom): static
    {
        $this->defaultZoom = $defaultZoom;

        return $this;
    }

    public function getDefaultZoom(): int
    {
        $zoom = $this->evaluate($this->defaultZoom);

        if (is_numeric($zoom)) {
            return $zoom;
        }

        return config('filament-locationpickr-field.default_zoom');
    }

    public function height(string | Closure $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getHeight(): string
    {
        return $this->evaluate($this->height) ?? config('filament-locationpickr-field.default_height');
    }

    /**
     * @throws JsonException
     */
    public function getMapConfig(): string
    {
        return json_encode([
            'defaultLocation' => $this->getDefaultLocation(),
            'defaultZoom' => $this->getDefaultZoom(),
            'apiKey' => config('filament-locationpickr-field.key'),
        ], JSON_THROW_ON_ERROR);
    }
}
