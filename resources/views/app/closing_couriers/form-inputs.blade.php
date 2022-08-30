@php $editing = isset($closingCourier) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.image name="image" label="Image">
        <div x-data="imageViewer('{{ $editing && $closingCourier->image ? \Storage::url($closingCourier->image) : '' }}')" class="mt-1 sm:mt-0 sm:col-span-2">
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

    <x-input.select name="bank_id" label="Bank" required>
        @php $selected = old('bank_id', ($editing ? $closingCourier->bank_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($banks as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.currency name="total_cash_to_transfer" label="Total Cash To Transfer"
        value="{{ old('total_cash_to_transfer', $editing ? $closingCourier->total_cash_to_transfer : '') }}" required>
    </x-input.currency>
    {{-- <x-input.hidden name="total_cash_to_transfer"
        value="{{ old('total_cash_to_transfer', $editing ? $closingCourier->total_cash_to_transfer : '0') }}" required>
    </x-input.hidden> --}}

    @role('staff|supervisor|manager')
        <x-inputs.hidden name="status" value="{{ old('status', $editing ? $closingCourier->status : '1') }}">
        </x-inputs.hidden>
    @endrole

    @role('super-admin')
        <x-input.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $closingCourier->status : '1')) @endphp
            <option value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diperiksa</option>
            <option value="2" {{ $selected == '2' ? 'selected' : '' }}>valid</option>
            <option value="3" {{ $selected == '3' ? 'selected' : '' }}>perbaiki</option>
            <option value="4" {{ $selected == '4' ? 'selected' : '' }}>periksa ulang</option>
        </x-input.select>
    @endrole

    <x-input.textarea name="notes" label="Notes" maxlength="255">
        {{ old('notes', $editing ? $closingCourier->notes : '') }}</x-input.textarea>

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $closingCourier->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $closingCourier->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            @role('super-admin|manager|supervisor')
                <x-shows.sub-dl>
                    <x-shows.dt>Created By</x-shows.dt>
                    <x-shows.dd>{{ optional($closingCourier->created_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
                @endrole @role('staff|super-admin')
                <x-shows.sub-dl>
                    <x-shows.dt>Updated By</x-shows.dt>
                    <x-shows.dd>{{ optional($closingCourier->approved_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
        </x-shows.dl>
    @endif
</div>
