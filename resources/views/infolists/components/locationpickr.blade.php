<x-dynamic-component
    :component="$getEntryWrapperView()"
    :entry="$entry"
>
    <div
        ax-load
        x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('locationpickr', 'arbermustafa/filament-locationpickr-field'))]"
        ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('locationpickr-entry', 'arbermustafa/filament-locationpickr-field') }}"
        wire:ignore
        x-data="locationPickrEntry({
            location: @js($getState()),
            config: {{ $getMapConfig() }},
        })"
        x-ignore
    >
        <div
            x-ref="map"
            class="locationPickr w-full"
            style="height: {{ $getHeight() }}"
        ></div>
    </div>
</x-dynamic-component>
