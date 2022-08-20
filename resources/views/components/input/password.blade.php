@props(['name', 'label', 'value' => ''])

<x-input.partials.group-head>
    <x-input.partials.label-desktop :name="$name" label="{{ $label ?? '' }}"></x-input.partials.label-desktop>
    <x-input.partials.group>
        <x-input.basic type="password" :name="$name" label="{{ $label ?? '' }}" :value="$value ?? ''"
            :attributes="$attributes">
        </x-input.basic>
    </x-input.partials.group>
</x-input.partials.group-head>
