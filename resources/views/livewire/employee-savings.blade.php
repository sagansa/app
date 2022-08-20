<div>
    <div>
        @can('create', App\Models\Saving::class)
        <button class="button" wire:click="newSaving">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\Saving::class)
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
                    <x-input.select
                        name="saving.debet_credit"
                        label="Debet Credit"
                        wire:model="saving.debet_credit"
                    >
                        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >Debet</option>
                        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >Credit</option>
                    </x-input.select>

                    <x-input.number
                        name="saving.nominal"
                        label="Nominal"
                        wire:model="saving.nominal"
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
                        @lang('crud.employee_savings.inputs.debet_credit')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.employee_savings.inputs.nominal')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($savings as $saving)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $saving->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $saving->debet_credit ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $saving->nominal ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $saving)
                            <button
                                type="button"
                                class="button"
                                wire:click="editSaving({{ $saving->id }})"
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
                    <td colspan="3">
                        <div class="mt-10 px-4">{{ $savings->render() }}</div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
