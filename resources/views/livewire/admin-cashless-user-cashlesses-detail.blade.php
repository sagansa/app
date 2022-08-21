<div>
    <div>
        @can('create', App\Models\UserCashless::class)
            <button class="button" wire:click="newUserCashless">
                <i class="mr-1 icon ion-md-add text-primary"></i>
                @lang('crud.common.new')
            </button>
            @endcan @can('delete-any', App\Models\UserCashless::class)
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

            <div class="mt-1 sm:space-y-5">

                <x-input.select name="userCashless.store_id" label="Store" wire:model="userCashless.store_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($storesForSelect as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.email name="userCashless.email" label="Email" wire:model="userCashless.email" maxlength="255">
                </x-input.email>

                <x-input.text name="userCashless.username" label="Username" wire:model="userCashless.username"
                    maxlength="50"></x-input.text>

                <x-input.number name="userCashless.no_telp" label="No Telp" wire:model="userCashless.no_telp">
                </x-input.number>

                <x-input.text name="userCashless.password" label="Password" wire:model="userCashless.password"
                    maxlength="255"></x-input.text>

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
                        <input type="checkbox" wire:model="allSelected" wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}" />
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.admin_cashless_user_cashlesses.inputs.store_id')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.admin_cashless_user_cashlesses.inputs.email')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.admin_cashless_user_cashlesses.inputs.username')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.admin_cashless_user_cashlesses.inputs.no_telp')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.admin_cashless_user_cashlesses.inputs.password')
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($userCashlesses as $userCashless)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            <input type="checkbox" value="{{ $userCashless->id }}" wire:model="selected" />
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ optional($userCashless->store)->name ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $userCashless->email ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $userCashless->username ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $userCashless->no_telp ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $userCashless->password ?? '-' }}
                        </x-tables.td-left>
                        <td class="px-4 py-3 text-right" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $userCashless)
                                    <button type="button" class="button"
                                        wire:click="editUserCashless({{ $userCashless->id }})">
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
                    <td colspan="6">
                        <div class="px-4 mt-10">
                            {{ $userCashlesses->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
