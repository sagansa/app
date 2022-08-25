<div>
    <div>
        @can('create', App\Models\PurchaseOrder::class)
        <button class="button" wire:click="newPurchaseOrder">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\PurchaseOrder::class)
        <button
            class="button button-danger"
             {{ empty($selected) ? 'disabled' : '' }} 
            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
            wire:click="destroySelected"
        >
            <i class="mr-1 icon ion-md-trash text-primary"></i>
            @lang('crud.common.delete_selected')
        </button>
        @endcan
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div>
                    <x-input.image name="purchaseOrderImage" label="Image">
                        <div
                            image-url="{{ $editing && $purchaseOrder->image ? \Storage::url($purchaseOrder->image) : '' }}"
                            x-data="imageViewer()"
                            @refresh.window="refreshUrl()"
                            class="mt-1 sm:mt-0 sm:col-span-2"
                        >
                            <!-- Show the image -->
                            <template x-if="imageUrl">
                                <img
                                    :src="imageUrl"
                                    class="
                                        object-cover
                                        rounded
                                        border border-gray-200
                                    "
                                    style="width: 100px; height: 100px;"
                                />
                            </template>

                            <!-- Show the gray box when image is not available -->
                            <template x-if="!imageUrl">
                                <div
                                    class="
                                        border
                                        rounded
                                        border-gray-200
                                        bg-gray-100
                                    "
                                    style="width: 100px; height: 100px;"
                                ></div>
                            </template>

                            <div class="mt-2">
                                <input
                                    type="file"
                                    name="purchaseOrderImage"
                                    id="purchaseOrderImage{{ $uploadIteration }}"
                                    wire:model="purchaseOrderImage"
                                    @change="fileChosen"
                                />
                            </div>

                            @error('purchaseOrderImage')
                            @include('components.inputs.partials.error')
                            @enderror
                        </div>
                    </x-input.image>

                    <x-input.select
                        name="purchaseOrder.payment_type_id"
                        label="Payment Type"
                        wire:model="purchaseOrder.payment_type_id"
                    >
                        <option value="null" disabled>Please select the Payment Type</option>
                        @foreach($paymentTypesForSelect as $value => $label)
                        <option value="{{ $value }}"  >{{ $label }}</option>
                        @endforeach
                    </x-input.select>

                    <x-input.select
                        name="purchaseOrder.supplier_id"
                        label="Supplier"
                        wire:model="purchaseOrder.supplier_id"
                    >
                        <option value="null" disabled>Please select the Supplier</option>
                        @foreach($suppliersForSelect as $value => $label)
                        <option value="{{ $value }}"  >{{ $label }}</option>
                        @endforeach
                    </x-input.select>

                    <x-input.date
                        name="purchaseOrderDate"
                        label="Date"
                        wire:model="purchaseOrderDate"
                        max="255"
                    ></x-input.date>

                    <x-input.number
                        name="purchaseOrder.taxes"
                        label="Taxes"
                        wire:model="purchaseOrder.taxes"
                        max="255"
                        placeholder="Taxes"
                    ></x-input.number>

                    <x-input.number
                        name="purchaseOrder.discounts"
                        label="Discounts"
                        wire:model="purchaseOrder.discounts"
                        max="255"
                        placeholder="Discounts"
                    ></x-input.number>

                    <x-input.select
                        name="purchaseOrder.payment_status"
                        label="Payment Status"
                        wire:model="purchaseOrder.payment_status"
                    >
                    </x-input.select>

                    <x-input.select
                        name="purchaseOrder.order_status"
                        label="Order Status"
                        wire:model="purchaseOrder.order_status"
                    >
                    </x-input.select>

                    <x-input.textarea
                        name="purchaseOrder.notes"
                        label="Notes"
                        wire:model="purchaseOrder.notes"
                        maxlength="255"
                    ></x-input.textarea>

                    <x-input.select
                        name="purchaseOrder.created_by_id"
                        label="Created By"
                        wire:model="purchaseOrder.created_by_id"
                    >
                        <option value="null" disabled>Please select the User</option>
                        @foreach($usersForSelect as $value => $label)
                        <option value="{{ $value }}"  >{{ $label }}</option>
                        @endforeach
                    </x-input.select>

                    <x-input.select
                        name="purchaseOrder.approved_by_id"
                        label="Approved By"
                        wire:model="purchaseOrder.approved_by_id"
                    >
                        <option value="null" disabled>Please select the User</option>
                        @foreach($usersForSelect as $value => $label)
                        <option value="{{ $value }}"  >{{ $label }}</option>
                        @endforeach
                    </x-input.select>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 flex justify-between">
            <button
                type="button"
                class="button"
                wire:click="$toggle('showingModal')"
            >
                <i class="mr-1 icon ion-md-close"></i>
                @lang('crud.common.cancel')
            </button>

            <button
                type="button"
                class="button button-primary"
                wire:click="save"
            >
                <i class="mr-1 icon ion-md-save"></i>
                @lang('crud.common.save')
            </button>
        </div>
    </x-modal>

    <div class="block w-full overflow-auto scrolling-touch mt-4">
        <table class="w-full max-w-full mb-4 bg-transparent">
            <thead class="text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left w-1">
                        <input
                            type="checkbox"
                            wire:model="allSelected"
                            wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}"
                        />
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.store_purchase_orders.inputs.image')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.store_purchase_orders.inputs.payment_type_id')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.store_purchase_orders.inputs.supplier_id')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.store_purchase_orders.inputs.date')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.store_purchase_orders.inputs.taxes')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.store_purchase_orders.inputs.discounts')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.store_purchase_orders.inputs.payment_status')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.store_purchase_orders.inputs.order_status')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.store_purchase_orders.inputs.notes')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.store_purchase_orders.inputs.created_by_id')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.store_purchase_orders.inputs.approved_by_id')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($purchaseOrders as $purchaseOrder)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $purchaseOrder->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        <x-partials.thumbnail
                            src="{{ $purchaseOrder->image ? \Storage::url($purchaseOrder->image) : '' }}"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($purchaseOrder->paymentType)->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($purchaseOrder->supplier)->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $purchaseOrder->date ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $purchaseOrder->taxes ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $purchaseOrder->discounts ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $purchaseOrder->payment_status ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $purchaseOrder->order_status ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $purchaseOrder->notes ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($purchaseOrder->created_by)->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($purchaseOrder->approved_by)->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $purchaseOrder)
                            <button
                                type="button"
                                class="button"
                                wire:click="editPurchaseOrder({{ $purchaseOrder->id }})"
                            >
                                <i class="icon ion-md-create"></i>
                            </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="12">
                        <div class="mt-10 px-4">
                            {{ $purchaseOrders->render() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
