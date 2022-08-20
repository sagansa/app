@props(['name', 'label'])

<x-input.partials.group-head>
    <x-input.partials.label-desktop :name="$name" label="{{ $label ?? '' }}"></x-input.partials.label-desktop>
    <x-input.partials.group class="sm:mt-0 md:col-span-3">
        @if ($label ?? null)
            @include('components.input.partials.label-mobile')
        @endif

        <textarea id="{{ $name }}" name="{{ $name }}" rows="3" {{ $required ?? false ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'block w-full border-0 p-0 text-xs text-gray-900 focus:ring-0']) }}
            autocomplete="off">{{ $slot }}</textarea>
        <p class="mt-2 text-xs italic text-red-500">*) Berikan catatan bila diperlukan</p>

        @error($name)
            @include('components.input.partials.error')
        @enderror
    </x-input.partials.group>
</x-input.partials.group-head>
