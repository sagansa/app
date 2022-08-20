<div>
    <div>
        @can('create', App\Models\ContractEmployee::class)
        <button class="button" wire:click="newContractEmployee">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\ContractEmployee::class)
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
                    <x-inputs.group class="w-full">
                        <x-inputs.partials.label
                            name="contractEmployeeFile"
                            label="File"
                        ></x-inputs.partials.label
                        ><br />

                        <input
                            type="file"
                            name="contractEmployeeFile"
                            id="contractEmployeeFile{{ $uploadIteration }}"
                            wire:model="contractEmployeeFile"
                            class="form-control-file"
                        />

                        @if($editing && $contractEmployee->file)
                        <div class="mt-2">
                            <a
                                href="{{ \Storage::url($contractEmployee->file) }}"
                                target="_blank"
                                ><i class="icon ion-md-download"></i
                                >&nbsp;Download</a
                            >
                        </div>
                        @endif @error('contractEmployeeFile')
                        @include('components.inputs.partials.error') @enderror
                    </x-inputs.group>

                    <x-input.date
                        name="contractEmployeeFromDate"
                        label="From Date"
                        wire:model="contractEmployeeFromDate"
                        max="255"
                    ></x-input.date>

                    <x-input.date
                        name="contractEmployeeUntilDate"
                        label="Until Date"
                        wire:model="contractEmployeeUntilDate"
                        max="255"
                    ></x-input.date>

                    <x-input.number
                        name="contractEmployee.nominal_guarantee"
                        label="Nominal Guarantee"
                        wire:model="contractEmployee.nominal_guarantee"
                        max="255"
                    ></x-input.number>

                    <x-input.select
                        name="contractEmployee.guarantee"
                        label="Guarantee"
                        wire:model="contractEmployee.guarantee"
                    >
                        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >1</option>
                        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >2</option>
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
                        @lang('crud.employee_contract_employees.inputs.from_date')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.employee_contract_employees.inputs.until_date')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.employee_contract_employees.inputs.nominal_guarantee')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.employee_contract_employees.inputs.guarantee')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($contractEmployees as $contractEmployee)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $contractEmployee->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $contractEmployee->from_date ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $contractEmployee->until_date ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $contractEmployee->nominal_guarantee ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $contractEmployee->guarantee ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $contractEmployee)
                            <button
                                type="button"
                                class="button"
                                wire:click="editContractEmployee({{ $contractEmployee->id }})"
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
                    <td colspan="5">
                        <div class="mt-10 px-4">
                            {{ $contractEmployees->render() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
