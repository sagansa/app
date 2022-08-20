<div>
    <form wire:submit.prevent="updatePurchaseOrder" autocomplete="off">
        <div
            class="relative px-3 py-1 text-xs border border-gray-300 rounded-md shadow-sm sm:col-span-2 focus-within:border-indigo-600 focus-within:ring-1 focus-within:ring-indigo-600">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <span class="text-xs text-gray-500">Rp</span>
            </div>

            <input type="number" wire:model.defer="state.discounts"
                class="block w-full p-0 text-xs font-medium text-right text-gray-500 placeholder-gray-500 border-0 focus:ring-0">

        </div>
    </form>

</div>
