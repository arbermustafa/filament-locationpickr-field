<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        ax-load
        ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-locationpickr-field', 'arbermustafa/filament-locationpickr-field') }}"
        wire:ignore
        x-data="locationPickr({
            location: $wire.$entangle('{{ $getStatePath() }}'),
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
