<div>
    <x-tables.card-overflow>
        <x-table>
            <x-slot name="head">
                <tr>
                    <x-tables.th-left>
                        <input type="checkbox" wire:model="allSelected" wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}" />
                    </x-tables.th-left>

                    <x-tables.th-left>
                        @lang('crud.purchase_order_products.inputs.product_id')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.purchase_order_products.inputs.quantity_product')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.purchase_order_products.inputs.quantity_invoice')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.purchase_order_products.inputs.subtotal_invoice')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.purchase_order_products.inputs.status')
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($purchaseOrderProducts as $purchaseOrderProduct)
                    <tr class="hover:bg-gray-100">

                        <x-tables.td-left>
                            <input type="checkbox" value="{{ $purchaseOrderProduct->id }}" wire:model="selected" />
                        </x-tables.td-left>

                        <x-tables.td-left>
                            @if ($purchaseOrderProduct->product->payment_type_id != $this->purchaseOrder->payment_type_id)
                                <x-spans.text-red>{{ optional($purchaseOrderProduct->product)->name ?? '-' }}
                                </x-spans.text-red>
                            @elseif ($purchaseOrderProduct->product->payment_type_id == $this->purchaseOrder->payment_type_id)
                                <x-spans.text-black>{{ optional($purchaseOrderProduct->product)->name ?? '-' }}
                                </x-spans.text-black>
                            @endif

                        </x-tables.td-left>
                        <x-tables.td-right>
                            <p>Prod: {{ $purchaseOrderProduct->quantity_product ?? '-' }}
                                {{ $purchaseOrderProduct->product->unit->unit }}</p>
                            <p>Inv: {{ $purchaseOrderProduct->quantity_invoice ?? '-' }}
                                {{ $purchaseOrderProduct->unit->unit ?? '-' }}</p>
                        </x-tables.td-right>
                        <x-tables.td-right>
                            @currency($purchaseOrderProduct->subtotal_invoice)
                        </x-tables.td-right>
                        @role('super-admin|manager')
                            <x-tables.td-left>
                                @if ($purchaseOrderProduct->status == 1)
                                    <x-spans.yellow>process</x-spans.yellow>
                                @elseif ($purchaseOrderProduct->status == 2)
                                    <x-spans.green>done</x-spans.green>
                                @elseif ($purchaseOrderProduct->status == 3)
                                    <x-spans.red>no need</x-spans.red>
                                @endif
                            </x-tables.td-left>
                        @endrole
                        <td class="px-4 py-1 text-right" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($purchaseOrder->payment_status != 2 || $purchaseOrder->order_status != 2)
                                    @can('update', $purchaseOrderProduct)
                                        <x-buttons.edit
                                            wire:click="editPurchaseOrderProduct({{ $purchaseOrderProduct->id }})">
                                        </x-buttons.edit>
                                    @endcan
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <x-tables.th-total colspan="3">Subtotals</x-tables.th-total>
                    <x-tables.td-total> @currency($purchaseOrderProducts->sum('subtotal_invoice'))</x-tables.td-total>
                </tr>
                <tr>
                    <x-tables.th-total colspan="3">Discounts</x-tables.th-total>
                    @if ($purchaseOrder->payment_status != 2 || $purchaseOrder->order_status != 2)
                        <x-input.wire-currency name="discounts" wiresubmit="updatePurchaseOrder"
                            wiremodel="state.discounts"></x-input.wire-currency>
                    @else
                        <x-tables.td-total>@currency($this->purchaseOrder->discounts)</x-tables.td-total>
                    @endif
                </tr>
                <tr>
                    <x-tables.th-total colspan="3">Taxes</x-tables.th-total>
                    @if ($purchaseOrder->payment_status != 2 || $purchaseOrder->order_status != 2)
                        <x-input.wire-currency name="taxes" wiresubmit="updatePurchaseOrder" wiremodel="state.taxes">
                        </x-input.wire-currency>
                    @else
                        <x-tables.td-total>@currency($this->purchaseOrder->taxes)</x-tables.td-total>
                    @endif
                </tr>
                <tr>
                    <x-tables.th-total colspan="3">Totals</x-tables.th-total>
                    <x-tables.td-total>@currency($this->purchaseOrder->totals)</x-tables.td-total>
                </tr>
                <tr>
                    <td colspan="6">
                        <div class="px-4 mt-10">
                            {{ $purchaseOrderProducts->render() }}
                        </div>
                    </td>
                </tr>

            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
