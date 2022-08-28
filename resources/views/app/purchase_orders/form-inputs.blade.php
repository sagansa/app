@php $editing = isset($purchaseOrder) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.image name="image" label="Image">
        <div x-data="imageViewer('{{ $editing && $purchaseOrder->image ? \Storage::url($purchaseOrder->image) : '' }}')" class="mt-1 sm:mt-0 sm:col-span-2">
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

    <x-input.select name="store_id" label="Store" required>
        @php $selected = old('store_id', ($editing ? $purchaseOrder->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($stores as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="supplier_id" label="Supplier" required>
        @php $selected = old('supplier_id', ($editing ? $purchaseOrder->supplier_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($suppliers as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="payment_type_id" label="Payment Type" required>
        @php $selected = old('payment_type_id', ($editing ? $purchaseOrder->payment_type_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($paymentTypes as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
            </option>
        @endforeach
    </x-input.select>

    <x-input.date name="date" label="Date"
        value="{{ old('date', $editing ? optional($purchaseOrder->date)->format('Y-m-d') : '') }}" required>
    </x-input.date>

    {{-- <x-input.number name="taxes" label="Taxes" value="{{ old('taxes', $editing ? $purchaseOrder->taxes : '') }}"
        required></x-input.number>

    <x-input.number name="discounts" label="Discounts"
        value="{{ old('discounts', $editing ? $purchaseOrder->discounts : '') }}" required></x-input.number> --}}


    <x-input.hidden name="taxes" value="{{ old('taxes', $editing ? $purchaseOrder->taxes : '1') }}">
    </x-input.hidden>

    <x-input.hidden name="discounts" value="{{ old('discounts', $editing ? $purchaseOrder->discounts : '1') }}">
    </x-input.hidden>


    <x-input.textarea name="notes" label="Notes" maxlength="255">
        {{ old('notes', $editing ? $purchaseOrder->notes : '') }}</x-input.textarea>

    @role('super-admin')
        <x-input.select name="payment_status" label="Payment Status">
            @php $selected = old('payment_status', ($editing ? $purchaseOrder->payment_status : '1')) @endphp
            <option value="1" {{ $selected == '1' ? 'selected' : '' }}>belum dibayar</option>
            <option value="2" {{ $selected == '2' ? 'selected' : '' }}>sudah dibayar</option>
            <option value="3" {{ $selected == '3' ? 'selected' : '' }}>tidak valid</option>
        </x-input.select>
    @endrole

    @role('supervisor|amanger|staff')
        <x-input.hidden name="payment_status"
            value="{{ old('payment_status', $editing ? $purchaseOrder->payment_status : '1') }}">
        </x-input.hidden>
    @endrole

    <x-input.select name="order_status" label="Order Status">
        @php $selected = old('order_status', ($editing ? $purchaseOrder->order_status : '1')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diterima</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }}>sudah diterima</option>
        <option value="3" {{ $selected == '3' ? 'selected' : '' }}>dikembalikan</option>
    </x-input.select>

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $purchaseOrder->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $purchaseOrder->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            @role('super-admin')
                <x-shows.sub-dl>
                    <x-shows.dt>Created By</x-shows.dt>
                    <x-shows.dd>{{ optional($purchaseOrder->created_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
        </x-shows.dl>
    @endif
</div>
