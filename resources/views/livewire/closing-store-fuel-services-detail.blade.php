<div>
    <div>
        @if ($closingStore->transfer_status != 2 || $closingStore->closing_status != 2)
            @can('create', App\Models\FuelService::class)
                <button class="button" wire:click="newFuelService">
                    <i class="mr-1 icon ion-md-add text-primary"></i>
                    @lang('crud.common.new')
                </button>
                @endcan @can('delete-any', App\Models\FuelService::class)
                <button class="button button-danger" {{ empty($selected) ? 'disabled' : '' }}
                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="destroySelected">
                    <i class="mr-1 icon ion-md-trash text-primary"></i>
                    @lang('crud.common.delete_selected')
                </button>
            @endcan
        @endif
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">

                <x-input.filepond name="fuelServiceImage" label="Room" wire:model="fuelServiceImage">
                </x-input.filepond>

                {{-- <x-input.image name="fuelServiceImage" label="Image">
                    <div image-url="{{ $editing && $fuelService->image ? \Storage::url($fuelService->image) : '' }}"
                        x-data="imageViewer()" @refresh.window="refreshUrl()" class="mt-1 sm:mt-0 sm:col-span-2">
                        <!-- Show the image -->
                        <template x-if="imageUrl">
                            <img :src="imageUrl" class="object-cover border border-gray-200 rounded "
                                style="width: 100px; height: 100px;" />
                        </template>

                        <!-- Show the gray box when image is not available -->
                        <template x-if="!imageUrl">
                            <div class="bg-gray-100 border border-gray-200 rounded "
                                style="width: 100px; height: 100px;"></div>
                        </template>

                        <div class="mt-2">
                            <input type="file" name="fuelServiceImage" id="fuelServiceImage{{ $uploadIteration }}"
                                wire:model="fuelServiceImage" @change="fileChosen" />
                        </div>

                        @error('fuelServiceImage')
                            @include('components.inputs.partials.error')
                        @enderror
                    </div>
                </x-input.image> --}}

                <x-input.select name="fuelService.vehicle_id" label="Vehicle" wire:model="fuelService.vehicle_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($vehiclesForSelect as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.select name="fuelService.fuel_service" label="Fuel Service"
                    wire:model="fuelService.fuel_service">
                    <option value="1" {{ $selected == '1' ? 'selected' : '' }}>fuel</option>
                    <option value="2" {{ $selected == '2' ? 'selected' : '' }}>service</option>
                </x-input.select>

                <x-input.number name="fuelService.km" label="km" wire:model="fuelService.km"></x-input.number>

                <x-input.number name="fuelService.liter" label="Liter" wire:model="fuelService.liter"></x-input.number>

                <x-input.currency name="fuelService.amount" label="Amount" wire:model="fuelService.amount">
                </x-input.currency>

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
                    @if ($closingStore->transfer_status != 2 || $closingStore->closing_status != 2)
                        <x-tables.th-left>
                            <input type="checkbox" wire:model="allSelected" wire:click="toggleFullSelection"
                                title="{{ trans('crud.common.select_all') }}" />
                        </x-tables.th-left>
                    @endif
                    <x-tables.th-left>
                        @lang('crud.closing_store_fuel_services.inputs.image')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.closing_store_fuel_services.inputs.vehicle_id')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.closing_store_fuel_services.inputs.fuel_service')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.closing_store_fuel_services.inputs.km')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.closing_store_fuel_services.inputs.liter')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.closing_store_fuel_services.inputs.amount')
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($fuelServices as $fuelService)
                    <tr class="hover:bg-gray-100">
                        @if ($closingStore->transfer_status != 2 || $closingStore->closing_status != 2)
                            <x-tables.td-left>
                                <input type="checkbox" value="{{ $fuelService->id }}" wire:model="selected" />
                            </x-tables.td-left>
                        @endif
                        <x-tables.td-left>
                            <x-partials.thumbnail
                                src="{{ $fuelService->image ? \Storage::url($fuelService->image) : '' }}" />
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ optional($fuelService->vehicle)->no_register }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            @if ($fuelService->fuel_service == 1)
                                fuel
                            @else
                                service
                            @endif
                        </x-tables.td-left>
                        <x-tables.td-left>
                            @number($fuelService->km)
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $fuelService->liter ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-right>
                            @currency($fuelService->amount)
                        </x-tables.td-right>
                        <td class="px-4 py-3 text-right" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @role('super-admin|manager|staff')
                                    @if ($closingStore->transfer_status != 2 || $closingStore->closing_status != 2)
                                        {{-- @can('update', $fuelService) --}}
                                        <button type="button" class="button"
                                            wire:click="editFuelService({{ $fuelService->id }})">
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                        {{-- @endcan --}}
                                    @endif
                                @endrole
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <th scope="row" colspan="6"
                        class="pt-1 pl-6 pr-3 text-xs font-semibold text-right text-gray-900 sm:table-cell md:pl-0">
                        Totals</th>

                    <td class="relative py-2 pl-3 pr-4 text-xs font-semibold text-right text-gray-500 sm:pr-6">
                        @currency($fuelServices->sum('amount'))
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <div class="px-4 mt-10">
                            {{ $fuelServices->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
