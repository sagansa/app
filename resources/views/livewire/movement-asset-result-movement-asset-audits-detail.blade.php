<div>
    <div>
        @can('create', App\Models\MovementAssetAudit::class)
        <button class="button" wire:click="newMovementAssetAudit">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\MovementAssetAudit::class)
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
                    <x-input.image name="movementAssetAuditImage" label="Image">
                        <div
                            image-url="{{ $editing && $movementAssetAudit->image ? \Storage::url($movementAssetAudit->image) : '' }}"
                            x-data="imageViewer()"
                            @refresh.window="refreshUrl()"
                            class="mt-1 sm:mt-0 sm:col-span-2"
                        >
                            <!-- Show the image -->
                            <template x-if="imageUrl">
                                <img
                                    :src="imageUrl"
                                    class="
                                        object-cover
                                        rounded
                                        border border-gray-200
                                    "
                                    style="width: 100px; height: 100px;"
                                />
                            </template>

                            <!-- Show the gray box when image is not available -->
                            <template x-if="!imageUrl">
                                <div
                                    class="
                                        border
                                        rounded
                                        border-gray-200
                                        bg-gray-100
                                    "
                                    style="width: 100px; height: 100px;"
                                ></div>
                            </template>

                            <div class="mt-2">
                                <input
                                    type="file"
                                    name="movementAssetAuditImage"
                                    id="movementAssetAuditImage{{ $uploadIteration }}"
                                    wire:model="movementAssetAuditImage"
                                    @change="fileChosen"
                                />
                            </div>

                            @error('movementAssetAuditImage')
                            @include('components.inputs.partials.error')
                            @enderror
                        </div>
                    </x-input.image>

                    <x-input.select
                        name="movementAssetAudit.movement_asset_id"
                        label="Movement Asset"
                        wire:model="movementAssetAudit.movement_asset_id"
                    >
                        <option value="null" disabled>Please select the Movement Asset</option>
                        @foreach($movementAssetsForSelect as $value => $label)
                        <option value="{{ $value }}"  >{{ $label }}</option>
                        @endforeach
                    </x-input.select>

                    <x-input.number
                        name="movementAssetAudit.good_cond_qty"
                        label="Good Cond Qty"
                        wire:model="movementAssetAudit.good_cond_qty"
                        max="255"
                        placeholder="Good Cond Qty"
                    ></x-input.number>

                    <x-input.number
                        name="movementAssetAudit.bad_cond_qty"
                        label="Bad Cond Qty"
                        wire:model="movementAssetAudit.bad_cond_qty"
                        max="255"
                        placeholder="Bad Cond Qty"
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
                        @lang('crud.movement_asset_result_movement_asset_audits.inputs.image')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.movement_asset_result_movement_asset_audits.inputs.movement_asset_id')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.movement_asset_result_movement_asset_audits.inputs.good_cond_qty')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.movement_asset_result_movement_asset_audits.inputs.bad_cond_qty')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($movementAssetAudits as $movementAssetAudit)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $movementAssetAudit->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        <x-partials.thumbnail
                            src="{{ $movementAssetAudit->image ? \Storage::url($movementAssetAudit->image) : '' }}"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($movementAssetAudit->movementAsset)->image
                        ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $movementAssetAudit->good_cond_qty ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $movementAssetAudit->bad_cond_qty ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $movementAssetAudit)
                            <button
                                type="button"
                                class="button"
                                wire:click="editMovementAssetAudit({{ $movementAssetAudit->id }})"
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
                            {{ $movementAssetAudits->render() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
