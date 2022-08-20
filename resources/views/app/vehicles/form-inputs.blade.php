@php $editing = isset($vehicle) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.image name="image" label="Image">
        <div x-data="imageViewer('{{ $editing && $vehicle->image ? \Storage::url($vehicle->image) : '' }}')" class="mt-1 sm:mt-0 sm:col-span-2">
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

    <x-input.text name="no_register" label="No Register"
        value="{{ old('no_register', $editing ? $vehicle->no_register : '') }}" maxlength="15" required>
    </x-input.text>

    <x-input.select name="type" label="Type">
        @php $selected = old('type', ($editing ? $vehicle->type : '1')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }}>motor</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }}>mobil</option>
        <option value="3" {{ $selected == '3' ? 'selected' : '' }}>truk</option>
    </x-input.select>

    <x-input.select name="store_id" label="Store" required>
        @php $selected = old('store_id', ($editing ? $vehicle->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($stores as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="user_id" label="Owner" required>
        @php $selected = old('user_id', ($editing ? $vehicle->user_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
            </option>
        @endforeach
    </x-input.select>

    <x-input.select name="status" label="Status">
        @php $selected = old('status', ($editing ? $vehicle->status : '1')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }}>active</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }}>inactive</option>
    </x-input.select>

    <x-input.textarea name="notes" label="Notes" maxlength="255">
        {{ old('notes', $editing ? $vehicle->notes : '') }}</x-input.textarea>

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $vehicle->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $vehicle->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
        </x-shows.dl>
    @endif
</div>
