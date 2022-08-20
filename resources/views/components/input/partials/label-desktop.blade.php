<label
    class="{{ $required ?? false ? 'label label-required block text-xs font-medium text-transparent sm:mt-px sm:pt-2 sm:text-gray-700' : 'label block text-xs font-medium text-transparent sm:mt-px sm:pt-2 sm:text-gray-700' }}"
    for="{{ $name }}">
    {{ $label }}
</label>
