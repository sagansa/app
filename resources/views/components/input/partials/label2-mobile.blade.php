<label
    class="{{ $required ?? false ? 'label label-required px-3 block text-xs font-medium text-gray-700 sm:hidden' : 'label px-3 block text-xs font-medium text-gray-700 sm:hidden' }}"
    for="{{ $name }}">
    {{ $label }}
</label>
