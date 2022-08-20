@props(['name', 'label'])

<x-input.partials.group-head class="w-full">
    <x-input.partials.label-desktop :name="$name" label="{{ $label ?? '' }}">
    </x-input.partials.label-desktop>
    <x-input.partials.group class="sm:mt-0 sm:col-span-2">
        @if ($label ?? null)
            @include('components.input.partials.label-mobile')
        @endif

        {{ $slot }}

    </x-input.partials.group>

</x-input.partials.group-head>
