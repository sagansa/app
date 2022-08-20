@props(['name', 'label', 'value', 'min' => null, 'max' => null, 'step' => null])

<x-input.partials.group-head>
    <x-input.partials.label-desktop :name="$name" label="{{ $label ?? '' }}"></x-input.partials.label-desktop>
    <x-input.partials.group>
        <x-input.basic class="text-right" type="number" :name="$name" label="{{ $label ?? '' }}" :value="$value ?? ''"
            :attributes="$attributes" :min="$min" :max="$max" :step="$step"></x-input.basic>
    </x-input.partials.group>
</x-input.partials.group-head>
