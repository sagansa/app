<div>
    <div>
        @can('create', App\Models\Product::class)
            <button class="button" wire:click="newProduct">
                <i class="mr-1 icon ion-md-add text-primary"></i>
                @lang('crud.common.attach')
            </button>
        @endcan
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div>
                    <x-input.select name="product_id" label="Product" wire:model="product_id">
                        <option value="null" disabled>-- select --</option>
                        @foreach ($productsForSelect as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-input.select>

                    <x-input.number name="quantity" label="Quantity" wire:model="quantity"></x-input.number>
                </div>
            </div>
        </div>

        <div class="flex justify-between px-6 py-4 bg-gray-50">
            <button type="button" class="button" wire:click="$toggle('showingModal')">
                <i class="mr-1 icon ion-md-close"></i>
                @lang('crud.common.cancel')
            </button>

            <button type="button" class="button button-primary" wire:click="save">
                <i class="mr-1 icon ion-md-save"></i>
                @lang('crud.common.save')
            </button>
        </div>
    </x-modal>

    <div class="block w-full mt-4 overflow-auto scrolling-touch">
        <table class="w-full max-w-full mb-4 bg-transparent">
            <thead class="text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.remaining_stock_products.inputs.product_id')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.remaining_stock_products.inputs.quantity')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($remainingStockProducts as $product)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-3 text-left">
                            {{ $product->name ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            {{ $product->pivot->quantity ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-right" style="width: 70px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('delete-any', App\Models\Product::class)
                                    <button class="button button-danger"
                                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                        wire:click="detach({{ $product->id }})">
                                        <i class="mr-1 icon ion-md-trash text-primary"></i>
                                        @lang('crud.common.detach')
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">
                        <div class="px-4 mt-10">
                            {{ $remainingStockProducts->render() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
