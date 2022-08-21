<div>
    <div>
        @can('create', App\Models\HygieneOfRoom::class)
            <button class="button" wire:click="newHygieneOfRoom">
                <i class="mr-1 icon ion-md-add text-primary"></i>
                @lang('crud.common.new')
            </button>
            @endcan @can('delete-any', App\Models\HygieneOfRoom::class)
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

                <x-input.select name="hygieneOfRoom.room_id" label="Room" wire:model="hygieneOfRoom.room_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($roomsForSelect as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <x-input.filepond name="hygieneOfRoomImage" label="Room" wire:model="hygieneOfRoomImage">
                </x-input.filepond>

                {{-- <x-input.image name="hygieneOfRoomImage" label="Image">
                    <div image-url="{{ $editing && $hygieneOfRoom->image ? \Storage::url('images/hygienes' . '/' . $hygieneOfRoom->image) : '' }}"
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
                            <input type="file" name="hygieneOfRoomImage"
                                id="hygieneOfRoomImage{{ $uploadIteration }}" wire:model="hygieneOfRoomImage"
                                @change="fileChosen" />
                        </div>

                        @error('hygieneOfRoomImage')
                            @include('components.inputs.partials.error')
                        @enderror
                    </div>
                </x-input.image> --}}

            </div>
        </div>

        <div class="flex justify-between px-6 py-4 bg-gray-50">
            <x-buttons.secondary wire:click="$toggle('showingModal')">Cancel</x-buttons.secondary>
            <x-jet-button wire:click="save">Save</x-jet-button>
        </div>
    </x-modal>

    <x-tables.card-overflow>
        <x-table>
            <x-slot name="head">
                <tr>
                    <x-tables.th-left>
                        <input class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500" type="checkbox"
                            wire:model="allSelected" wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}" />
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.hygiene_hygiene_of_rooms.inputs.room_id')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.hygiene_hygiene_of_rooms.inputs.image')
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($hygieneOfRooms as $hygieneOfRoom)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            <input class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500"
                                type="checkbox" value="{{ $hygieneOfRoom->id }}" wire:model="selected" />
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ optional($hygieneOfRoom->room)->name ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            @if ($hygieneOfRoom->image == null)
                                <x-partials.thumbnail src="" />
                            @else
                                <a href="{{ \Storage::url('images/hygienes' . '/' . $hygieneOfRoom->image) }}">
                                    <x-partials.thumbnail
                                        src="{{ $hygieneOfRoom->image ? \Storage::url('images/hygienes' . '/' . $hygieneOfRoom->image) : '' }}" />
                                </a>
                            @endif
                        </x-tables.td-left>
                        <td class="px-4 py-3 text-right" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $hygieneOfRoom)
                                    <button type="button" class="button"
                                        wire:click="editHygieneOfRoom({{ $hygieneOfRoom->id }})">
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
                            {{ $hygieneOfRooms->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
