<div>
    <div>
        @if ($closingStore->transfer_status != 2 || $closingStore->closing_status != 2)
            @can('create', App\Models\ClosingStore::class)
                <button class="button" wire:click="newPurchaseOrder">
                    <i class="mr-1 icon ion-md-add text-primary"></i>
                    @lang('crud.common.attach')
                </button>
            @endcan
        @endif
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
                <x-input.select name="purchase_order_id" label="Purchase Order" wire:model="purchase_order_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($purchaseOrdersForSelect as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>
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

            <x-buttons.secondary wire:click="$toggle('showingModal')">@lang('crud.common.cancel')</x-buttons.secondary>
            <x-jet-button wire:click="save">@lang('crud.common.save')</x-jet-button>
        </div>
    </x-modal>

    <x-tables.card-overflow>
        <x-table>
            <x-slot name="head">
                <tr>
                    {{-- <x-tables.th-left>
                        @lang('crud.closing_store_purchase_orders.inputs.purchase_order_id')
                    </x-tables.th-left> --}}
                    <x-tables.th-left>
                        Store
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Date
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Supplier
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Discounts - Taxes
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Detail Order
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Subtotal
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($closingStorePurchaseOrders as $purchaseOrder)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            {{ $purchaseOrder->store->nickname ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $purchaseOrder->date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $purchaseOrder->supplier->name ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-right>
                            <p>discounts: @currency($purchaseOrder->discounts)</p>
                            <p>taxes: @currency($purchaseOrder->taxes)</p>
                        </x-tables.td-right>
                        <x-tables.td-right>
                            @foreach ($purchaseOrder->purchaseOrderProducts as $purchaseOrderProduct)
                                <p>{{ $purchaseOrderProduct->product->name }}</p>
                            @endforeach
                        </x-tables.td-right>
                        <x-tables.td-right>
                            @foreach ($purchaseOrder->purchaseOrderProducts as $purchaseOrderProduct)
                                <p>@currency($purchaseOrderProduct->subtotal_invoice)</p>
                            @endforeach
                        </x-tables.td-right>
                        <td class="px-4 py-3 text-right" style="width: 70px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($closingStore->transfer_status != '2' || $closingStore->closing_status != '2')
                                    {{-- @can('delete-any', App\Models\CloasingStore::class) --}}
                                    <button class="button button-danger"
                                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                        wire:click="detach({{ $purchaseOrder->id }})">
                                        <i class="icon ion-md-trash text-primary"></i>
                                    </button>
                                    {{-- @endcan --}}
                                @endif

                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <th scope="row" colspan="5"
                        class="pt-1 pl-6 pr-3 text-xs font-semibold text-right text-gray-900 sm:table-cell md:pl-0">
                        Totals</th>

                    <td class="relative py-2 pl-3 pr-4 text-xs font-semibold text-right text-gray-500 sm:pr-6">
                        @currency($this->totals)
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="px-4 mt-10">
                            {{ $closingStorePurchaseOrders->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
