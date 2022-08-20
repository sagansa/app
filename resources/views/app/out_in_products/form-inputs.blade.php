@php $editing = isset($outInProduct) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.image name="image" label="Image">
        <x-ps.image>*) dapat berupa foto penerima/pemberi, foto
            barang sebagai bukti serah terima, atau foto pendukung lainnya.</x-ps.image>
        <div x-data="imageViewer('{{ $editing && $outInProduct->image ? \Storage::url($outInProduct->image) : '' }}')" class="mt-1 sm:mt-0 sm:col-span-2">
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

    <x-input.select name="stock_card_id" label="Stock Card" required>
        @php $selected = old('stock_card_id', ($editing ? $outInProduct->stock_card_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($stockCards as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="out_in" label="Out/In">
        @php $selected = old('out_in', ($editing ? $outInProduct->out_in : '')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }}>keluar</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }}>masuk</option>
    </x-input.select>

    <x-input.text name="to_from" label="Receiver/Sender"
        value="{{ old('to_from', $editing ? $outInProduct->to_from : '') }}" maxlength="50" required></x-input.text>

    @if ($editing)
        @role('super-admin|manager')
            <x-input.select name="status" label="Status">
                @php $selected = old('status', ($editing ? $outInProduct->status : '1')) @endphp
                <option disabled value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diperiksa</option>
                <option value="2" {{ $selected == '2' ? 'selected' : '' }}>valid</option>
                <option value="3" {{ $selected == '3' ? 'selected' : '' }}>perbaiki</option>
                <option disabled value="4" {{ $selected == '4' ? 'selected' : '' }}>periksa ulang</option>
            </x-input.select>
        @endrole

        @role('storage-staff')
            @if ($outInProduct->approved_by_id != null)
                <x-input.select name="status" label="Status">
                    @php $selected = old('status', ($editing ? $outInProduct->status : '1')) @endphp
                    <option disabled value="3" {{ $selected == '3' ? 'selected' : '' }}>perbaiki</option>
                    <option value="4" {{ $selected == '4' ? 'selected' : '' }}>periksa ulang</option>
                </x-input.select>
            @else
                <x-input.hidden name="status" value="{{ old('status', $editing ? $outInProduct->status : '1') }}">
                </x-input.hidden>
            @endif
        @endrole

    @endif

    @if (!$editing)
        <x-input.hidden name="status" value="{{ old('status', $editing ? $outInProduct->result : '1') }}">
        </x-input.hidden>
    @endif

    <x-input.textarea name="notes" label="Notes" maxlength="255">
        {{ old('notes', $editing ? $outInProduct->notes : '') }}</x-input.textarea>

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $outInProduct->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $outInProduct->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            @role('super-admin|manager|supervisor')
                <x-shows.sub-dl>
                    <x-shows.dt>Created By</x-shows.dt>
                    <x-shows.dd>{{ optional($outInProduct->created_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
                @endrole @role('staff|super-admin')
                <x-shows.sub-dl>
                    <x-shows.dt>Updated By</x-shows.dt>
                    <x-shows.dd>{{ optional($outInProduct->approved_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
        </x-shows.dl>
    @endif
</div>
