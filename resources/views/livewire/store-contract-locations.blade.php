<div>
    <div>
        @can('create', App\Models\ContractLocation::class)
            <button class="button" wire:click="newContractLocation">
                <i class="mr-1 icon ion-md-add text-primary"></i>
                @lang('crud.common.new')
            </button>
            @endcan @can('delete-any', App\Models\ContractLocation::class)
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

                <x-input.file name="contractLocationFile" label="File">

                    <br />

                    <input type="file" name="contractLocationFile" id="contractLocationFile{{ $uploadIteration }}"
                        wire:model="contractLocationFile" class="form-control-file" />

                    @if ($editing && $contractLocation->file)
                        <div class="mt-2">
                            <a href="{{ \Storage::url($contractLocation->file) }}" target="_blank"><i
                                    class="icon ion-md-download"></i>&nbsp;Download</a>
                        </div>
                    @endif
                    @error('contractLocationFile')
                        @include('components.inputs.partials.error')
                    @enderror
                </x-input.file>

                <x-input.textarea name="contractLocation.address" label="Address" wire:model="contractLocation.address"
                    maxlength="255"></x-input.textarea>

                <x-input.select name="contractLocation.province_id" label="Province"
                    wire:model="contractLocation.province_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($provincesForSelect as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.select name="contractLocation.regency_id" label="Regency"
                    wire:model="contractLocation.regency_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($regenciesForSelect as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.select name="contractLocation.district_id" label="District"
                    wire:model="contractLocation.district_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($districtsForSelect as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.select name="contractLocation.village_id" label="Village"
                    wire:model="contractLocation.village_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($villagesForSelect as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.number name="contractLocation.codepos" label="Codepos" wire:model="contractLocation.codepos">
                </x-input.number>

                <x-input.text name="contractLocation.gps_location" label="GPS Location"
                    wire:model="contractLocation.gps_location"></x-input.text>

                <x-input.date name="contractLocationFromDate" label="From Date" wire:model="contractLocationFromDate"
                    max="255"></x-input.date>

                <x-input.date name="contractLocationUntilDate" label="Until Date" wire:model="contractLocationUntilDate"
                    max="255"></x-input.date>

                <x-input.text name="contractLocation.contact_person" label="Contact Person"
                    wire:model="contractLocation.contact_person" maxlength="255"></x-input.text>

                <x-input.number name="contractLocation.no_contact_person" label="No Telp Contact Person"
                    wire:model="contractLocation.no_contact_person"></x-input.number>

                <x-input.number name="contractLocation.nominal_contract_per_year" label="Nominal Contract Per Year"
                    wire:model="contractLocation.nominal_contract_per_year"></x-input.number>

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
                    <th class="w-1 px-4 py-3 text-left">
                        <input type="checkbox" wire:model="allSelected" wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}" />
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.store_contract_locations.inputs.address')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.store_contract_locations.inputs.from_date')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.store_contract_locations.inputs.until_date')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.store_contract_locations.inputs.contact_person')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.store_contract_locations.inputs.no_contact_person')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.store_contract_locations.inputs.nominal_contract_per_year')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($contractLocations as $contractLocation)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-3 text-left">
                            <input type="checkbox" value="{{ $contractLocation->id }}" wire:model="selected" />
                        </td>
                        <td class="px-4 py-3 text-left">
                            {{ $contractLocation->address ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-left">
                            {{ $contractLocation->from_date ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-left">
                            {{ $contractLocation->until_date ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-left">
                            {{ $contractLocation->contact_person ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            {{ $contractLocation->no_contact_person ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            {{ $contractLocation->nominal_contract_per_year ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-right" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $contractLocation)
                                    <button type="button" class="button"
                                        wire:click="editContractLocation({{ $contractLocation->id }})">
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
                    <td colspan="7">
                        <div class="px-4 mt-10">
                            {{ $contractLocations->render() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
