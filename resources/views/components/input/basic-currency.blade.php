 @if ($label ?? null)
     @include('components.input.partials.label-mobile')
 @endif

 <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
     <span class="text-xs text-gray-500">Rp</span>
 </div>
 <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
     value="{{ old($name, $value ?? '') }}" {{ $required ?? false ? 'required' : '' }}
     {{ $attributes->merge([
         'class' => 'block w-full p-0 text-gray-900 placeholder-gray-500 border-0 focus:ring-0 text-xs',
     ]) }}
     {{ $min ? "min={$min}" : '' }} {{ $max ? "max={$max}" : '' }} {{ $step ? "step={$step}" : '' }} autocomplete="off">

 @error($name)
     @include('components.inputs.partials.error')
 @enderror
