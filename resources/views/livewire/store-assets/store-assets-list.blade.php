<div>
    <div>
        @can('create', App\Models\MovementAsset::class)
            <button class="button" wire:click="newMovementAsset">
                <i class="mr-1 icon ion-md-add text-primary"></i>
                @lang('crud.common.new')
            </button>
            @endcan @can('delete-any', App\Models\MovementAsset::class)
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

                {{-- <x-input.image name="movementAssetImage" label="Image">
                    <div image-url="{{ $editing && $movementAsset->image ? \Storage::url($movementAsset->image) : '' }}"
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
                            <input type="file" name="movementAssetImage"
                                id="movementAssetImage{{ $uploadIteration }}" wire:model="movementAssetImage"
                                @change="fileChosen" />
                        </div>

                        @error('movementAssetImage')
                            @include('components.inputs.partials.error')
                        @enderror
                    </div>
                </x-input.image> --}}

                <x-input.filepond label="image" name="movementAssetImage"></x-input.filepond>

                <x-input.image name="movementAssetQrCode" label="QR Code">
                    <div image-url="{{ $editing && $movementAsset->qr_code ? \Storage::url($movementAsset->qr_code) : '' }}"
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
                            <input type="file" name="movementAssetQrCode"
                                id="movementAssetQrCode{{ $uploadIteration }}" wire:model="movementAssetQrCode"
                                @change="fileChosen" />
                        </div>

                        @error('movementAssetQrCode')
                            @include('components.inputs.partials.error')
                        @enderror
                    </div>
                </x-input.image>



                <x-input.select name="movementAsset.product_id" label="Product" wire:model="movementAsset.product_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($productsForSelect as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.number name="movementAsset.good_cond_qty" label="Good Cond Qty"
                    wire:model="movementAsset.good_cond_qty"></x-input.number>

                <x-input.number name="movementAsset.bad_cond_qty" label="Bad Cond Qty"
                    wire:model="movementAsset.bad_cond_qty"></x-input.number>

                {{-- <x-input.select name="movementAsset.user_id" label="User" wire:model="movementAsset.user_id">
                        <option value="null" disabled>-- select --</option>
                        @foreach ($usersForSelect as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-input.select> --}}

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
                            title="{{ trans('crud.common.select_all') }}"
                            class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500" />
                    </th>
                    <x-tables.th-left>
                        @lang('crud.store_asset_movement_assets.inputs.image')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.store_asset_movement_assets.inputs.qr_code')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.store_asset_movement_assets.inputs.product_id')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.store_asset_movement_assets.inputs.good_cond_qty')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.store_asset_movement_assets.inputs.bad_cond_qty')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.store_asset_movement_assets.inputs.user_id')
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($movementAssets as $movementAsset)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-3 text-left">
                            <input type="checkbox" value="{{ $movementAsset->id }}" wire:model="selected"
                                class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500" />
                        </td>
                        <x-tables.td-left>
                            <a href="{{ \Storage::url($movementAsset->image) }}">
                                <x-partials.thumbnail
                                    src="{{ $movementAsset->image ? \Storage::url($movementAsset->image) : '' }}" />
                            </a>
                        </x-tables.td-left>
                        <x-tables.td-left>
                            <a href="{{ \Storage::url($movementAsset->qr_code) }}">
                                <x-partials.thumbnail
                                    src="{{ $movementAsset->qr_code ? \Storage::url($movementAsset->qr_code) : '' }}" />
                            </a>
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ optional($movementAsset->product)->name ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $movementAsset->good_cond_qty ?? '-' }} {{ $movementAsset->product->unit->unit }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $movementAsset->bad_cond_qty ?? '-' }} {{ $movementAsset->product->unit->unit }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ optional($movementAsset->user)->name ?? '-' }}
                        </x-tables.td-left>
                        <td class="px-4 py-3 text-right" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $movementAsset)
                                    <button type="button" class="button"
                                        wire:click="editMovementAsset({{ $movementAsset->id }})">
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
                    <td colspan="7">
                        <div class="px-4 mt-10">
                            {{ $movementAssets->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
