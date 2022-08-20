<div
    {{ $attributes->merge([
        'class' =>
            'sm:col-span-2 text-xs relative px-3 py-2 border border-gray-300 rounded-md shadow-sm focus-within:border-indigo-600 focus-within:ring-1 focus-within:ring-indigo-600',
    ]) }}>
    {{ $slot }}
</div>
