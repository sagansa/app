<div>
    <div>
        @role('super-admin')
            @can('create', App\Models\PurchaseReceipt::class)
                <button class="button" wire:click="newPurchaseOrder">
                    <i class="mr-1 icon ion-md-add text-primary"></i>
                    @lang('crud.common.attach')
                </button>
            @endcan
        @endrole
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div>
                    <x-input.select name="purchase_order_id" label="Purchase Order" wire:model="purchase_order_id">
                        <option value="null" disabled>-- select --</option>
                        @foreach ($purchaseOrdersForSelect as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-input.select>
                </div>
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
            <x-buttons.secondary wire:click="$toggle('showingModal')">Cancel</x-buttons.secondary>
            <x-jet-button wire:click="save">Save</x-jet-button>
        </div>
    </x-modal>

    <x-tables.card-overflow>
        <x-table>
            <x-slot name="head">
                <tr>
                    <x-tables.th-left>
                        {{-- @lang('crud.purchase_receipt_purchase_orders.inputs.purchase_order_id') --}}
                        Date
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Supplier
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Store
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
                    @role('super-admin|manager')
                        <x-tables.th-left>
                            Payment Status
                        </x-tables.th-left>
                        <th></th>
                    @endrole
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($purchaseReceiptPurchaseOrders as $purchaseOrder)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            {{ $purchaseOrder->date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            <p class="text-right sm:text-left">
                                {{ optional($purchaseOrder->supplier)->bank_account_name ?? '-' }}
                            </p>
                            <p class="text-right sm:text-left">{{ optional($purchaseOrder->supplier)->name ?? '-' }}
                            </p>
                            <p class="text-right sm:text-left">
                                {{ optional($purchaseOrder->supplier)->bank->name ?? '-' }}</p>
                            <p class="text-right sm:text-left">
                                {{ optional($purchaseOrder->supplier)->bank_account_no ?? '-' }}
                            </p>
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $purchaseOrder->store->nickname ?? '-' }}
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
                        @role('super-admin|manager')
                            <x-tables.td-left>
                                <select
                                    class="block w-full py-2 pl-3 pr-10 mt-1 text-xs border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    wire:change="changePaymentStatus({{ $purchaseOrder }}, $event.target.value)">
                                    <option value="1" {{ $purchaseOrder->payment_status == '1' ? 'selected' : '' }}>
                                        Belum Dibayar</option>
                                    <option value="2" {{ $purchaseOrder->payment_status == '2' ? 'selected' : '' }}>
                                        Sudah Dibayar</option>
                                </select>
                            </x-tables.td-left>
                        @endrole
                        <td class="px-4 py-3 text-right" style="width: 70px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('delete-any', App\Models\PurchaseReceipt::class)
                                    <button class="button button-danger"
                                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                        wire:click="detach({{ $purchaseOrder->id }})">
                                        <i class="icon ion-md-trash text-primary"></i>

                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                @role('super-admin|manager')
                    <tr>
                        <x-tables.th-total colspan="5">Total Invoice</x-tables.th-total>
                        <x-tables.td-total>@currency($this->totals)</x-tables.td-total>
                    </tr>
                    <tr>
                        <x-tables.th-total colspan="5">Nominal Transfer</x-tables.th-total>
                        @role('supervisor|manager|staff')
                            <x-tables.td-total>@currency($this->purchaseReceipt->nominal_transfer)</x-tables.td-total>
                        @endrole
                        @role('super-admin')
                            <x-input.wire-currency name="nominal_transfer" wiresubmit="updatePurchaseReceipt"
                                wiremodel="state.nominal_transfer"></x-input.wire-currency>
                        @endrole
                    </tr>
                    <tr>
                        <x-tables.th-total colspan="5">Difference</x-tables.th-total>
                        <x-tables.td-total>
                            @if ($this->difference < 0)
                                <x-spans.text-red>@currency($this->difference) </x-spans.text-red>
                            @else
                                <x-spans.text-green>@currency($this->difference) </x-spans.text-green>
                            @endif
                        </x-tables.td-total>
                    </tr>
                @endrole
                <tr>
                    <td colspan="2">
                        <div class="px-4 mt-10">
                            {{ $purchaseReceiptPurchaseOrders->render() }}
                        </div>
                    </td>
                </tr>

            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
