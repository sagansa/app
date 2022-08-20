{{-- -- Important note:
--
-- This template is based on an example from Tailwind UI, and is used here with permission from Tailwind Labs
-- for educational purposes only. Please do not use this template in your own projects without purchasing a
-- Tailwind UI license, or they’ll have to tighten up the licensing and you’ll ruin the fun for everyone.
--
-- Purchase here: https://tailwindui.com/ --}}
<div class="mt-1 sm:mt-0 sm:col-span-2">
    <button
        {{ $attributes->merge([
            'type' => 'button',
            'class' =>
                'ml-5 mt-2 text-xs underline font-medium' .
                ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''),
        ]) }}>
        {{ $slot }}
    </button>
</div>
