<button type="button" {{ $attributes }} wire:loading.attr="disabled" {{ $this->selectedCount ? '' : 'disabled' }}
    class="px-4 py-2 mt-1 mr-1 text-xs font-medium text-gray-800 uppercase bg-gray-200 border border-transparent rounded-md hover:text-gray-700 hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">
    {{ $slot }}
</button>
