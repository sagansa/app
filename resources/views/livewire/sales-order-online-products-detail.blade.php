<div>
    <div>
        {{-- @can('create', App\Models\SalesOrderOnline::class) --}}
        @if ($salesOrderOnline->status != 2)
            <button class="button" wire:click="newProduct">
                <i class="mr-1 icon ion-md-add text-primary"></i>
                @lang('crud.common.attach')
            </button>
        @endif
        {{-- @endcan --}}
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-1 sm:space-y-5">

                <x-input.select name="product_id" label="Product" wire:model="product_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($productsForSelect as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.number name="quantity" label="Quantity" wire:model="quantity"></x-input.number>

                <x-input.currency name="price" label="Price" wire:model="price"></x-input.currency>

            </div>
        </div>

        <div class="flex justify-between px-6 py-4 bg-gray-50">
            {{-- <button type="button" class="button" wire:click="$toggle('showingModal')">
                <i class="mr-1 icon ion-md-close"></i>
                @lang('crud.common.cancel')
            </button>

            <button type="button" class="button button-primary" wire:click="save">
                <i class="mr-1 icon ion-md-save"></i>
                @lang('crud.common.save')
            </button> --}}

            <x-buttons.secondary wire:click="$toggle('showingModal')"> @lang('crud.common.cancel')</x-buttons.secondary>
            <x-jet-button wire:click="save"> @lang('crud.common.save')</x-jet-button>
        </div>
    </x-modal>

    <x-tables.card-overflow>
        <x-table>
            <x-slot name="head">
                <tr>
                    <x-tables.th-left>
                        @lang('crud.sales_order_online_products.inputs.product_id')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.sales_order_online_products.inputs.quantity')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.sales_order_online_products.inputs.price')
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($salesOrderOnlineProducts as $product)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            {{ $product->name ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-right>
                            {{ $product->pivot->quantity ?? '-' }} {{ $product->unit->unit }}
                        </x-tables.td-right>
                        <x-tables.td-right>
                            @currency($product->pivot->price)
                        </x-tables.td-right>
                        <td class="px-4 py-3 text-right" style="width: 70px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                {{-- @can('delete-any', App\Models\SalesOrderOnline::class) --}}
                                @if ($salesOrderOnline->status != 2)
                                    <button class="button button-danger"
                                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                        wire:click="detach({{ $product->id }})">
                                        <i class="icon ion-md-trash text-primary"></i>
                                    </button>
                                @endif
                                {{-- @endcan --}}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <td colspan="4">
                        <div class="px-4 mt-10">
                            {{ $salesOrderOnlineProducts->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
