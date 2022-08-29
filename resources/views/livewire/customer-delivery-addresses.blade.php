<div>
    <div>
        @can('create', App\Models\DeliveryAddress::class)
        <button class="button" wire:click="newDeliveryAddress">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\DeliveryAddress::class)
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
                    <x-input.text
                        name="deliveryAddress.name"
                        label="Name"
                        wire:model="deliveryAddress.name"
                        maxlength="255"
                    ></x-input.text>

                    <x-input.text
                        name="deliveryAddress.recipients_name"
                        label="Recipients Name"
                        wire:model="deliveryAddress.recipients_name"
                        maxlength="255"
                    ></x-input.text>

                    <x-input.number
                        name="deliveryAddress.recipients_telp_no"
                        label="Recipients Telp No"
                        wire:model="deliveryAddress.recipients_telp_no"
                    ></x-input.number>

                    <x-input.textarea
                        name="deliveryAddress.address"
                        label="Address"
                        wire:model="deliveryAddress.address"
                        maxlength="255"
                    ></x-input.textarea>

                    <x-input.select
                        name="deliveryAddress.province_id"
                        label="Province"
                        wire:model="deliveryAddress.province_id"
                    >
                        <option value="null" disabled>-- select --</option>
                        @foreach($provincesForSelect as $value => $label)
                        <option value="{{ $value }}"  >{{ $label }}</option>
                        @endforeach
                    </x-input.select>

                    <x-input.select
                        name="deliveryAddress.regency_id"
                        label="Regency"
                        wire:model="deliveryAddress.regency_id"
                    >
                        <option value="null" disabled>-- select --</option>
                        @foreach($regenciesForSelect as $value => $label)
                        <option value="{{ $value }}"  >{{ $label }}</option>
                        @endforeach
                    </x-input.select>

                    <x-input.select
                        name="deliveryAddress.district_id"
                        label="District"
                        wire:model="deliveryAddress.district_id"
                    >
                        <option value="null" disabled>-- select --</option>
                        @foreach($districtsForSelect as $value => $label)
                        <option value="{{ $value }}"  >{{ $label }}</option>
                        @endforeach
                    </x-input.select>

                    <x-input.select
                        name="deliveryAddress.village_id"
                        label="Village"
                        wire:model="deliveryAddress.village_id"
                    >
                        <option value="null" disabled>-- select --</option>
                        @foreach($villagesForSelect as $value => $label)
                        <option value="{{ $value }}"  >{{ $label }}</option>
                        @endforeach
                    </x-input.select>

                    <x-input.number
                        name="deliveryAddress.codepos"
                        label="Codepos"
                        wire:model="deliveryAddress.codepos"
                    ></x-input.number>
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
                        @lang('crud.customer_delivery_addresses.inputs.name')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.customer_delivery_addresses.inputs.recipients_name')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.customer_delivery_addresses.inputs.recipients_telp_no')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.customer_delivery_addresses.inputs.address')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.customer_delivery_addresses.inputs.regency_id')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($deliveryAddresses as $deliveryAddress)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $deliveryAddress->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $deliveryAddress->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $deliveryAddress->recipients_name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $deliveryAddress->recipients_telp_no ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $deliveryAddress->address ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($deliveryAddress->regency)->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $deliveryAddress)
                            <button
                                type="button"
                                class="button"
                                wire:click="editDeliveryAddress({{ $deliveryAddress->id }})"
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
                    <td colspan="6">
                        <div class="mt-10 px-4">
                            {{ $deliveryAddresses->render() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
