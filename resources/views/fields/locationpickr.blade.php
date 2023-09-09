<x-forms::field-wrapper
        :id="$getId()"
        :label="$getLabel()"
        :label-sr-only="$isLabelHidden()"
        :helper-text="$getHelperText()"
        :hint="$getHint()"
        :required="$isRequired()"
        :state-path="$getStatePath()"
>
    <div
        x-data="{
            location: $wire.entangle('{{ $getStatePath() }}'),
            lp: {},
        }"
        id="{{  $getId() . '-alpine' }}"
        x-init="
            (async () => {
                if (!document.getElementById('filament-location-picker-css')) {
                    const link  = document.createElement('link');
                    link.id   = 'filament-location-picker-css';
                    link.rel  = 'stylesheet';
                    link.type = 'text/css';
                    link.href = '/ear/filament/components/location-picker.css';
                    link.media = 'all';
                    document.head.appendChild(link);
                }

                if (!document.getElementById('filament-location-picker-js')) {
                    const script = document.createElement('script');
                    script.id   = 'filament-location-picker-js';
                    script.type = 'text/javascript';
                    script.src = '/ear/filament/components/location-picker.js';
                    document.head.appendChild(script);
                }

                do {
                    await (new Promise(resolve => setTimeout(resolve, 100)));
                } while (window.locationPicker === undefined);

                lp = locationPicker($wire, {{ $getMapConfig() }});
                lp.init($refs.map);
            })();

            $watch('location', value => lp.updateMapFromAlpine());
        "
    wire:ignore>
        <div
            x-ref="map"
            class="w-full"
            style="height: {{ $getHeight() }}; min-height: 30vh; z-index: 1 !important;"></div>
    </div>
</x-forms::field-wrapper>
