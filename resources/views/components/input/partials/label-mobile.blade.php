<label
    class="{{ $required ?? false ? 'label label-required absolute inline-block px-1 -mt-px text-xs font-medium text-gray-900 bg-white -top-2 left-2 sm:hidden' : 'label absolute inline-block px-1 -mt-px text-xs font-medium text-gray-900 bg-white -top-2 left-2 sm:hidden' }}"
    for="{{ $name }}">
    {{ $label }}
</label>
