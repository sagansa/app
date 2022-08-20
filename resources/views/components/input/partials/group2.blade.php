<div
    {{ $attributes->merge([
        'class' =>
            'sm:col-span-2 relative shadow-sm focus-within:border-indigo-600 focus-within:ring-1 focus-within:ring-indigo-600',
    ]) }}>
    {{ $slot }}
</div>
