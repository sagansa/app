@php $editing = isset($purchaseReceipt) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.image name="image" label="Image">
        <div x-data="imageViewer('{{ $editing && $purchaseReceipt->image ? \Storage::url($purchaseReceipt->image) : '' }}')" class="mt-1 sm:mt-0 sm:col-span-2">
            <!-- Show the image -->
            <template x-if="imageUrl">
                <img :src="imageUrl" class="object-cover border border-gray-200 rounded"
                    style="width: 100px; height: 100px;" />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div class="bg-gray-100 border border-gray-200 rounded" style="width: 100px; height: 100px;"></div>
            </template>

            <div class="mt-2">
                <input type="file" name="image" id="image" @change="fileChosen" />
            </div>

            @error('image')
                @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-input.image>

    {{-- <x-input.currency name="nominal_transfer" label="Nominal Transfer"
        value="{{ old('nominal_transfer', $editing ? $purchaseReceipt->nominal_transfer : '') }}" required>
    </x-input.currency> --}}

    <x-input.hidden name="nominal_transfer"
        value="{{ old('nominal_transfer', $editing ? $purchaseReceipt->nominal_transfer : '0') }}" required>
    </x-input.hidden>

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $purchaseReceipt->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $purchaseReceipt->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
        </x-shows.dl>
    @endif
</div>
