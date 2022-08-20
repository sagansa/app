@props(['name', 'label', 'type' => 'text'])


<x-input.partials.group-head>
    <x-input.partials.label-desktop :name="$name" label="{{ $label ?? '' }}"></x-input.partials.label-desktop>
    <x-input.partials.group>
        @if ($label ?? null)
            @include('components.input.partials.label-mobile')
        @endif

        <select id="{{ $name }}" name="{{ $name }}" {{ $required ?? false ? 'required' : '' }}
            {{ $attributes->merge([
                'class' => 'block w-full p-0 text-xs text-gray-900 border-0 focus:ring-0',
            ]) }}
            autocomplete="off">{{ $slot }}</select>

        @error($name)
            @include('components.inputs.partials.error')
        @enderror
    </x-input.partials.group>
</x-input.partials.group-head>
