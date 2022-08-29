@php $editing = isset($salesOrderOnline) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.image name="image" label="Image">
        <div x-data="imageViewer('{{ $editing && $salesOrderOnline->image ? \Storage::url($salesOrderOnline->image) : '' }}')" class="mt-1 sm:mt-0 sm:col-span-2">
            <!-- Show the image -->
            <template x-if="imageUrl">
                <img :src="imageUrl" class="object-cover border border-gray-200 rounded"
                    style="width: 100px; height: 100px;" />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div class="bg-gray-100 border border-gray-200 rounded" style="width: 100px; height: 100px;"></div>
            </template>

            @role('super-admin|manager')
                <div class="mt-2">
                    <input type="file" name="image" id="image" @change="fileChosen" />
                </div>
            @endrole

            @error('image')
                @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-input.image>

    <x-input.select name="store_id" label="Store" required>
        @php $selected = old('store_id', ($editing ? $salesOrderOnline->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($stores as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="online_shop_provider_id" label="Online Shop Provider" required>
        @php $selected = old('online_shop_provider_id', ($editing ? $salesOrderOnline->online_shop_provider_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($onlineShopProviders as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="delivery_service_id" label="Delivery Service" required>
        @php $selected = old('delivery_service_id', ($editing ? $salesOrderOnline->delivery_service_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($deliveryServices as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
            </option>
        @endforeach
    </x-input.select>

    <x-input.select name="customer_id" label="Customer">
        @php $selected = old('customer_id', ($editing ? $salesOrderOnline->customer_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($customers as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
            </option>
        @endforeach
    </x-input.select>

    <x-input.text name="receipt_no" label="Receipt No"
        value="{{ old('receipt_no', $editing ? $salesOrderOnline->receipt_no : '') }}" maxlength="255">
    </x-input.text>

    <x-input.date name="date" label="Date"
        value="{{ old('date', $editing ? optional($salesOrderOnline->date)->format('Y-m-d') : 'today()') }}" required>
    </x-input.date>

    <x-input.select name="status" label="Status">
        @php $selected = old('status', ($editing ? $salesOrderOnline->status : '1')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }}>belum dikirim</option>
        @role('super-admin|manager')
            <option value="2" {{ $selected == '2' ? 'selected' : '' }}>valid</option>
        @endrole
        <option value="3" {{ $selected == '3' ? 'selected' : '' }}>sudah dikirim</option>
        <option value="4" {{ $selected == '4' ? 'selected' : '' }}>dikembalikan</option>
    </x-input.select>

    <x-input.image name="image_sent" label="Image Sent">
        <div x-data="imageViewer('{{ $editing && $salesOrderOnline->image_sent ? \Storage::url($salesOrderOnline->image_sent) : '' }}')" class="mt-1 sm:mt-0 sm:col-span-2">
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
                <input type="file" name="image_sent" id="image_sent" @change="fileChosen" />
            </div>

            @error('image_sent')
                @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-input.image>

    {{-- <x-input.select name="created_by_id" label="Created By">
        @php $selected = old('created_by_id', ($editing ? $salesOrderOnline->created_by_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
            </option>
        @endforeach
    </x-input.select>

    <x-input.select name="approved_by_id" label="Approved By">
        @php $selected = old('approved_by_id', ($editing ? $salesOrderOnline->approved_by_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
            </option>
        @endforeach
    </x-input.select> --}}

    <x-input.textarea name="notes" label="Notes" maxlength="255">
        {{ old('notes', $editing ? $salesOrderOnline->notes : '') }}</x-input.textarea>

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $salesOrderOnline->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $salesOrderOnline->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            @role('super-admin|manager')
                <x-shows.sub-dl>
                    <x-shows.dt>Created By</x-shows.dt>
                    <x-shows.dd>{{ optional($salesOrderOnline->created_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
                <x-shows.sub-dl>
                    <x-shows.dt>Updated By</x-shows.dt>
                    <x-shows.dd>{{ optional($salesOrderOnline->approved_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
        </x-shows.dl>
    @endif
</div>
