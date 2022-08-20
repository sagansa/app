@props(['name', 'label', 'value', 'type' => 'text', 'min' => null, 'max' => null, 'step' => null])

@if ($label ?? null)
    @include('components.input.partials.label-mobile')
@endif

<input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
    value="{{ old($name, $value ?? '') }}" {{ $required ?? false ? 'required' : '' }}
    {{ $attributes->merge([
        'class' => 'block w-full p-0 text-xs text-gray-900 border-0 focus:ring-0',
    ]) }}
    {{ $min ? "min={$min}" : '' }} {{ $max ? "max={$max}" : '' }} {{ $step ? "step={$step}" : '' }}
    autocomplete="off">

@error($name)
    @include('components.input.partials.error')
@enderror
