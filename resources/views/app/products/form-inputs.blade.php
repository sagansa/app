@php $editing = isset($product) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.image name="barcode" label="Barcode">
        <div
            x-data="imageViewer('{{ $editing && $product->barcode ? \Storage::url($product->barcode) : '' }}')"
            class="mt-1 sm:mt-0 sm:col-span-2"
        >
            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input
                    type="file"
                    name="barcode"
                    id="barcode"
                    @change="fileChosen"
                />
            </div>

            @error('barcode') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-input.image>

    <x-input.image name="image" label="Image">
        <div
            x-data="imageViewer('{{ $editing && $product->image ? \Storage::url($product->image) : '' }}')"
            class="mt-1 sm:mt-0 sm:col-span-2"
        >
            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input
                    type="file"
                    name="image"
                    id="image"
                    @change="fileChosen"
                />
            </div>

            @error('image') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-input.image>

    <x-input.text
        name="name"
        label="Name"
        value="{{ old('name', ($editing ? $product->name : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="slug"
        label="Slug"
        value="{{ old('slug', ($editing ? $product->slug : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="sku"
        label="SKU"
        value="{{ old('sku', ($editing ? $product->sku : '')) }}"
        maxlength="255"
    ></x-input.text>

    <x-input.textarea name="description" label="Description" maxlength="255"
        >{{ old('description', ($editing ? $product->description : ''))
        }}</x-input.textarea
    >

    <x-input.select name="unit_id" label="Unit" required>
        @php $selected = old('unit_id', ($editing ? $product->unit_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($units as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="material_group_id" label="Material Group" required>
        @php $selected = old('material_group_id', ($editing ? $product->material_group_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($materialGroups as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="franchise_group_id" label="Franchise Group" required>
        @php $selected = old('franchise_group_id', ($editing ? $product->franchise_group_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($franchiseGroups as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="payment_type_id" label="Payment Type" required>
        @php $selected = old('payment_type_id', ($editing ? $product->payment_type_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($paymentTypes as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="online_category_id" label="Online Category" required>
        @php $selected = old('online_category_id', ($editing ? $product->online_category_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($onlineCategories as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="product_group_id" label="Product Group" required>
        @php $selected = old('product_group_id', ($editing ? $product->product_group_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($productGroups as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select
        name="restaurant_category_id"
        label="Restaurant Category"
        required
    >
        @php $selected = old('restaurant_category_id', ($editing ? $product->restaurant_category_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($restaurantCategories as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="request" label="Request">
        @php $selected = old('request', ($editing ? $product->request : '1')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >active</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >inactive</option>
    </x-input.select>

    <x-input.select name="remaining" label="Remaining">
        @php $selected = old('remaining', ($editing ? $product->remaining : '1')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >active</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >inactive</option>
    </x-input.select>

    @if ($editing)
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>Created Date</x-shows.dt>
            <x-shows.dd>{{ $product->created_at }} </x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Updated Date</x-shows.dt>
            <x-shows.dd>{{ $product->updated_at }} </x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager|supervisor')
        <x-shows.sub-dl>
            <x-shows.dt>Created By</x-shows.dt>
            <x-shows.dd
                >{{ optional($product->created_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole @role('staff|super-admin')
        <x-shows.sub-dl>
            <x-shows.dt>Updated By</x-shows.dt>
            <x-shows.dd
                >{{ optional($product->approved_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
    @endif
</div>
