@props(['id', 'name', 'label', 'type' => 'text'])

<x-input.partials.group-head>
    <x-input.partials.label-desktop :name="$name" label="{{ $label ?? '' }}"></x-input.partials.label-desktop>
    <x-input.partials.group2>
        @if ($label ?? null)
            @include('components.input.partials.label2-mobile')
        @endif

        <div wire:ignore>
            <select style="width: 100%" id="{{ $id }}" name="{{ $name }}"
                {{ $required ?? false ? 'required' : '' }}
                {{ $attributes->merge([
                    'class' =>
                        'block w-full p-0 text-xs text-gray-900 border-0 focus:ring-0 js-example-basic-single js-states form-control',
                ]) }}
                autocomplete="off">{{ $slot }}</select>
        </div>

        @error($name)
            @include('components.inputs.partials.error')
        @enderror
    </x-input.partials.group2>
</x-input.partials.group-head>
