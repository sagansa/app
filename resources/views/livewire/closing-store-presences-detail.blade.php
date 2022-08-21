<div>
    <div>
        @can('create', App\Models\Presence::class)
            <button class="button" wire:click="newPresence">
                <i class="mr-1 icon ion-md-add text-primary"></i>
                @lang('crud.common.new')
            </button>
            @endcan @can('delete-any', App\Models\Presence::class)
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

            <div class="mt-5">
                <div>
                    <x-input.select name="presence.created_by_id" label="Created By"
                        wire:model="presence.created_by_id">
                        <option value="null" disabled>Please select the User</option>
                        @foreach ($usersForSelect as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-input.select>

                    <x-input.currency name="presence.amount" label="Amount" wire:model="presence.amount" max="255"
                        placeholder="Amount"></x-input.currency>
                </div>
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
                        @lang('crud.closing_store_presences.inputs.created_by_id')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.closing_store_presences.inputs.amount')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($presences as $presence)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-3 text-left">
                            <input type="checkbox" value="{{ $presence->id }}" wire:model="selected" />
                        </td>
                        <td class="px-4 py-3 text-left">
                            {{ optional($presence->created_by)->name ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            {{ $presence->amount ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-right" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $presence)
                                    <button type="button" class="button" wire:click="editPresence({{ $presence->id }})">
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
                        <div class="px-4 mt-10">{{ $presences->render() }}</div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
