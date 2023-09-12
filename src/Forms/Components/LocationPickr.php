<?php

namespace ArberMustafa\FilamentLocationPickrField\Forms\Components;

use Closure;
use Exception;
use Filament\Forms\Components\Field;
use JsonException;

class LocationPickr extends Field
{
    protected string $view = 'filament-locationpickr-field::forms.components.locationpickr';

    protected int $precision = 8;

    protected array | Closure | null $defaultLocation = [0, 0];

    protected Closure | int $defaultZoom = 8;

    protected Closure | bool $draggable = true;

    protected Closure | bool $clickable = false;

    protected Closure | array $mapControls = [];

    protected Closure | string $height = '400px';

    protected Closure | string | null $myLocationButtonLabel = 'My location';

    private array $mapConfig = [
        'draggable' => true,
        'clickable' => false,
        'defaultLocation' => [
            'lat' => 41.32836109345274,
            'lng' => 19.818383186960773,
        ],
        'controls' => [],
        'statePath' => '',
        'defaultZoom' => 8,
        'myLocationButtonLabel' => '',
        'apiKey' => '',
    ];

    public array $controls = [
        'mapTypeControl' => true,
        'scaleControl' => true,
        'streetViewControl' => true,
        'rotateControl' => true,
        'fullscreenControl' => true,
        'zoomControl' => false,
    ];

    public function defaultLocation(Closure | array $location): static
    {
        $this->defaultLocation = $location;

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

    public function defaultZoom(Closure | int $defaultZoom): static
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

    public function draggable(Closure | bool $draggable = true): static
    {
        $this->draggable = $draggable;

        return $this;
    }

    public function getDraggable(): bool
    {
        return $this->evaluate($this->draggable);
    }

    public function clickable(Closure | bool $clickable = true): static
    {
        $this->clickable = $clickable;

        return $this;
    }

    public function getClickable(): bool
    {
        return $this->evaluate($this->clickable);
    }

    public function mapControls(Closure | array $controls): static
    {
        $this->mapControls = $controls;

        return $this;
    }

    /**
     * @throws JsonException
     */
    public function getMapControls(): string
    {
        $controls = $this->evaluate($this->mapControls);

        return json_encode(array_merge($this->controls, $controls), JSON_THROW_ON_ERROR);
    }

    public function height(Closure | string $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getHeight(): string
    {
        return $this->evaluate($this->height);
    }

    public function myLocationButtonLabel(Closure | string $label): static
    {
        $this->myLocationButtonLabel = $label;

        return $this;
    }

    public function getMyLocationButtonLabel(): string
    {
        $myLocationButtonLabel = $this->evaluate($this->myLocationButtonLabel);

        if (filled($myLocationButtonLabel)) {
            return $myLocationButtonLabel;
        }

        return config('filament-locationpickr-field.my_location_button');
    }

    /**
     * @throws JsonException
     */
    public function getMapConfig(): string
    {
        return json_encode(
            array_merge($this->mapConfig, [
                'draggable' => $this->getDraggable(),
                'clickable' => $this->getClickable(),
                'defaultLocation' => $this->getDefaultLocation(),
                'statePath' => $this->getStatePath(),
                'controls' => $this->getMapControls(),
                'defaultZoom' => $this->getDefaultZoom(),
                'myLocationButtonLabel' => $this->getMyLocationButtonLabel(),
                'apiKey' => config('filament-locationpickr-field.key'),
            ]),
            JSON_THROW_ON_ERROR
        );
    }

    /**
     * @throws JsonException
     */
    public function getState(): array
    {
        $state = parent::getState();

        if (is_array($state)) {
            return $state;
        } else {
            try {
                return @json_decode($state, true, 512, JSON_THROW_ON_ERROR);
            } catch (Exception $e) {
                return $this->getDefaultLocation();
            }
        }
    }
}
