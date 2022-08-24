<div>
    <div>
        @if ($closingStore->transfer_status != 2 || $closingStore->closing_status != 2)
            @can('create', App\Models\Cashless::class)
                <button class="button" wire:click="newCashless">
                    <i class="mr-1 icon ion-md-add text-primary"></i>
                    @lang('crud.common.new')
                </button>
                @endcan @can('delete-any', App\Models\Cashless::class)
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

                {{-- <x-input.filepond name="cashlessImage" label="Image" wire:model="cashlessImage"></x-input.filepond> --}}

                <x-input.image name="cashlessImage" label="Image">
                    <div image-url="{{ $editing && $cashless->image ? \Storage::url($cashless->image) : '' }}"
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
                            <input type="file" name="cashlessImage" id="cashlessImage{{ $uploadIteration }}"
                                wire:model="cashlessImage" @change="fileChosen" />
                        </div>

                        @error('cashlessImage')
                            @include('components.inputs.partials.error')
                        @enderror
                    </div>
                </x-input.image>

                <x-input.select name="cashless.account_cashless_id" label="Account Cashless"
                    wire:model="cashless.account_cashless_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($accountCashlessesForSelect as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.currency name="cashless.bruto_apl" label="Bruto Application" wire:model="cashless.bruto_apl">
                </x-input.currency>

                <x-input.currency name="cashless.netto_apl" label="Netto Application" wire:model="cashless.netto_apl">
                </x-input.currency>

                <x-input.filepond name="cashlessImageCanceled" label="Image Canceled"
                    wire:model="cashlessImageCanceled"></x-input.filepond>

                {{-- <x-input.image name="cashlessImageCanceled" label="Image Canceled">
                    <div image-url="{{ $editing && $cashless->image_canceled ? \Storage::url($cashless->image_canceled) : '' }}"
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
                            <input type="file" name="cashlessImageCanceled"
                                id="cashlessImageCanceled{{ $uploadIteration }}" wire:model="cashlessImageCanceled"
                                @change="fileChosen" />
                        </div>

                        @error('cashlessImageCanceled')
                            @include('components.inputs.partials.error')
                        @enderror
                    </div>
                </x-input.image> --}}

                <x-input.number name="cashless.canceled" label="Canceled" wire:model="cashless.canceled">
                </x-input.number>

                <x-input.currency name="cashless.bruto_real" label="Bruto Real" wire:model="cashless.bruto_real">
                </x-input.currency>

                <x-input.currency name="cashless.netto_real" label="Netto Real" wire:model="cashless.netto_real">
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
                        <th class="w-1 px-4 py-3 text-left">
                            <input type="checkbox" wire:model="allSelected" wire:click="toggleFullSelection"
                                title="{{ trans('crud.common.select_all') }}" />
                        </th>
                    @endif
                    <x-tables.th-left>
                        @lang('crud.closing_store_cashlesses.inputs.image')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.closing_store_cashlesses.inputs.account_cashless_id')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        {{-- @lang('crud.closing_store_cashlesses.inputs.bruto_apl') --}}
                        Omzet Application
                    </x-tables.th-left>
                    {{-- <x-tables.th-left>
                        @lang('crud.closing_store_cashlesses.inputs.netto_apl')
                    </x-tables.th-left> --}}
                    <x-tables.th-left>
                        @lang('crud.closing_store_cashlesses.inputs.image_canceled')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.closing_store_cashlesses.inputs.canceled')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        {{-- @lang('crud.closing_store_cashlesses.inputs.bruto_real') --}}
                        Omzet Real
                    </x-tables.th-left>
                    {{-- <x-tables.th-left>
                        @lang('crud.closing_store_cashlesses.inputs.netto_real')
                    </x-tables.th-left> --}}
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($cashlesses as $cashless)
                    <tr class="hover:bg-gray-100">
                        @if ($closingStore->transfer_status != 2 || $closingStore->closing_status != 2)
                            <x-tables.td-left>
                                <input type="checkbox" value="{{ $cashless->id }}" wire:model="selected" />
                            </x-tables.td-left>
                        @endif
                        <x-tables.td-left>
                            @if ($cashless->image == null)
                                <x-partials.thumbnail src="" />
                            @else
                                <a href="{{ \Storage::url($cashless->image) }}">
                                    <x-partials.thumbnail
                                        src="{{ $cashless->image ? \Storage::url($cashless->image) : '' }}" />
                                </a>
                            @endif
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ optional($cashless->accountCashless)->email ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-right>
                            <p>Bruto: @currency($cashless->bruto_apl)</p>
                            <p>Netto: @currency($cashless->netto_apl)</p>
                        </x-tables.td-right>
                        <x-tables.td-left>
                            @if ($cashless->image_canceled == null)
                                <x-partials.thumbnail src="" />
                            @else
                                <a href="{{ \Storage::url($cashless->image_canceled) }}">
                                    <x-partials.thumbnail
                                        src="{{ $cashless->image_canceled ? \Storage::url($cashless->image_canceled) : '' }}" />
                                </a>
                            @endif
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $cashless->canceled ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-right>
                            <p>Bruto: @currency($cashless->bruto_real)</p>
                            <p>Netto: @currency($cashless->netto_real)</p>
                        </x-tables.td-right>
                        <td class="px-4 py-3 text-right" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($closingStore->transfer_status != 2 || $closingStore->closing_status != 2)
                                    @can('update', $closingStore)
                                        <button type="button" class="button"
                                            wire:click="editCashless({{ $cashless->id }})">
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    @endcan
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">

                </tr>
                <tr>
                    <td colspan="9">
                        <div class="px-4 mt-10">
                            {{ $cashlesses->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
