<div>
    <div>
        @can('create', App\Models\VehicleTax::class)
            <button class="button" wire:click="newVehicleTax">
                <i class="mr-1 icon ion-md-add text-primary"></i>
                @lang('crud.common.new')
            </button>
            @endcan @can('delete-any', App\Models\VehicleTax::class)
            <button class="button button-danger" {{ empty($selected) ? 'disabled' : '' }}
                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="destroySelected">
                <i class="mr-1 icon ion-md-trash text-primary"></i>
                @lang('crud.common.delete_selected')
            </button>
        @endcan
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">

                <x-input.currency name="vehicleTax.amount_tax" label="Amount Tax" wire:model="vehicleTax.amount_tax">
                </x-input.currency>

                <x-input.date name="vehicleTaxExpiredDate" label="Expired Date" wire:model="vehicleTaxExpiredDate"
                    max="255"></x-input.date>

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
                    <th class="w-1 px-4 py-3 text-left">
                        <input type="checkbox" wire:model="allSelected" wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}" />
                    </th>
                    <x-tables.th-left>
                        @lang('crud.vehicle_taxes.inputs.amount_tax')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.vehicle_taxes.inputs.expired_date')
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($vehicleTaxes as $vehicleTax)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-3 text-left">
                            <input type="checkbox" value="{{ $vehicleTax->id }}" wire:model="selected" />
                        </td>
                        <x-tables.td-right>
                            {{ $vehicleTax->amount_tax ?? '-' }}
                        </x-tables.td-right>
                        <x-tables.td-left>
                            {{ $vehicleTax->expired_date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left>
                        <td class="px-4 py-3 text-right" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $vehicleTax)
                                    <button type="button" class="button"
                                        wire:click="editVehicleTax({{ $vehicleTax->id }})">
                                        <i class="icon ion-md-create"></i>
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <td colspan="3">
                        <div class="px-4 mt-10">
                            {{ $vehicleTaxes->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
