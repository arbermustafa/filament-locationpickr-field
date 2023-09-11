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
        id="{{ $getId() }}"
        x-data="locationPickr({
                    location: $wire.entangle('{{ $getStatePath() }}'),
                    config: {{ $getMapConfig() }},
                })"
        wire:ignore
    >
        <div
            x-ref="map"
            class="locationPickr w-full"
            style="height: {{ $getHeight() }}"
        ></div>
    </div>
</x-forms::field-wrapper>
