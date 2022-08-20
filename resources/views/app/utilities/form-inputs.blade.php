@php $editing = isset($utility) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.text
        name="number"
        label="Number"
        value="{{ old('number', ($editing ? $utility->number : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="name"
        label="Name"
        value="{{ old('name', ($editing ? $utility->name : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.select name="store_id" label="Store" required>
        @php $selected = old('store_id', ($editing ? $utility->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($stores as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="category" label="Category">
        @php $selected = old('category', ($editing ? $utility->category : '')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >listrik</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >air</option>
        <option value="3" {{ $selected == '3' ? 'selected' : '' }} >internet</option>
    </x-input.select>

    <x-input.select name="unit_id" label="Unit" required>
        @php $selected = old('unit_id', ($editing ? $utility->unit_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($units as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select
        name="utility_provider_id"
        label="Utility Provider"
        required
    >
        @php $selected = old('utility_provider_id', ($editing ? $utility->utility_provider_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($utilityProviders as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="pre_post" label="Pre Post">
        @php $selected = old('pre_post', ($editing ? $utility->pre_post : '')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >pre</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >post</option>
    </x-input.select>

    <x-input.select name="status" label="Status">
        @php $selected = old('status', ($editing ? $utility->status : '')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >active</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >inactive</option>
    </x-input.select>

    @if ($editing)
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>Created Date</x-shows.dt>
            <x-shows.dd>{{ $utility->created_at }} </x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Updated Date</x-shows.dt>
            <x-shows.dd>{{ $utility->updated_at }} </x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager|supervisor')
        <x-shows.sub-dl>
            <x-shows.dt>Created By</x-shows.dt>
            <x-shows.dd
                >{{ optional($utility->created_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole @role('staff|super-admin')
        <x-shows.sub-dl>
            <x-shows.dt>Updated By</x-shows.dt>
            <x-shows.dd
                >{{ optional($utility->approved_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
    @endif
</div>
