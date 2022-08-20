@props(['control', 'title'])

<li>
    <div @click.away="open = false" class="relative" x-data="{ open: false }">
        <button @click="open = !open" <button type="button"
            class="flex items-center w-full p-2 text-sm font-medium text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
            aria-controls={{ $control }} data-collapse-toggle={{ $control }}>
            {{ $content }}
            <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>
                {{ $title ?? '' }}</span>
            <svg fill="currentColor" viewBox="0 0 20 20" :class="{ 'rotate-180': open, 'rotate-0': !open }"
                class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1">
                <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>
        <ul id={{ $control }} class="hidden py-2 space-y-2">
            {{ $slot }}
        </ul>
    </div>
</li>
