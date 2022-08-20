@php $editing = isset($vehicleCertificate) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.select name="vehicle_id" label="Vehicle" required>
        @php $selected = old('vehicle_id', ($editing ? $vehicleCertificate->vehicle_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($vehicles as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="BPKB" label="BPKB">
        @php $selected = old('BPKB', ($editing ? $vehicleCertificate->BPKB : '2')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }}>ada</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }}>hilang</option>
    </x-input.select>

    <x-input.select name="STNK" label="STNK">
        @php $selected = old('STNK', ($editing ? $vehicleCertificate->STNK : '')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }}>ada</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }}>hilang</option>
    </x-input.select>

    <x-input.text name="name" label="Name" value="{{ old('name', $editing ? $vehicleCertificate->name : '') }}"
        maxlength="255" required></x-input.text>

    <x-input.text name="brand" label="Brand" value="{{ old('brand', $editing ? $vehicleCertificate->brand : '') }}"
        maxlength="255" required></x-input.text>

    <x-input.text name="type" label="Type" value="{{ old('type', $editing ? $vehicleCertificate->type : '') }}"
        maxlength="255" required></x-input.text>

    <x-input.text name="category" label="Category"
        value="{{ old('category', $editing ? $vehicleCertificate->category : '') }}" maxlength="255" required>
    </x-input.text>

    <x-input.text name="model" label="Model" value="{{ old('model', $editing ? $vehicleCertificate->model : '') }}"
        maxlength="255" required>
    </x-input.text>

    <x-input.text name="manufacture_year" label="Manufacture Year"
        value="{{ old('manufacture_year', $editing ? $vehicleCertificate->manufacture_year : '') }}" maxlength="255"
        required></x-input.text>

    <x-input.text name="cylinder_capacity" label="Cylinder Capacity"
        value="{{ old('cylinder_capacity', $editing ? $vehicleCertificate->cylinder_capacity : '') }}" maxlength="255"
        required></x-input.text>

    <x-input.text name="vehilce_identity_no" label="Vehilce Identity No"
        value="{{ old('vehilce_identity_no', $editing ? $vehicleCertificate->vehilce_identity_no : '') }}"
        maxlength="255" required></x-input.text>

    <x-input.text name="engine_no" label="Engine No"
        value="{{ old('engine_no', $editing ? $vehicleCertificate->engine_no : '') }}" maxlength="255" required>
    </x-input.text>

    <x-input.text name="color" label="Color" value="{{ old('color', $editing ? $vehicleCertificate->color : '') }}"
        maxlength="255" required>
    </x-input.text>

    <x-input.text name="type_fuel" label="Type Fuel"
        value="{{ old('type_fuel', $editing ? $vehicleCertificate->type_fuel : '') }}" maxlength="255" required>
    </x-input.text>

    <x-input.text name="lisence_plate_color" label="Lisence Plate Color"
        value="{{ old('lisence_plate_color', $editing ? $vehicleCertificate->lisence_plate_color : '') }}"
        maxlength="255" required></x-input.text>

    <x-input.text name="registration_year" label="Registration Year"
        value="{{ old('registration_year', $editing ? $vehicleCertificate->registration_year : '') }}" maxlength="255"
        required></x-input.text>

    <x-input.text name="bpkb_no" label="BPKB No"
        value="{{ old('bpkb_no', $editing ? $vehicleCertificate->bpkb_no : '') }}" maxlength="255" required>
    </x-input.text>

    <x-input.text name="location_code" label="Location Code"
        value="{{ old('location_code', $editing ? $vehicleCertificate->location_code : '') }}" maxlength="255"
        required></x-input.text>

    <x-input.text name="registration_queue_no" label="Registration Queue No"
        value="{{ old('registration_queue_no', $editing ? $vehicleCertificate->registration_queue_no : '') }}"
        maxlength="255" required></x-input.text>

    <x-input.textarea name="notes" label="Notes" maxlength="255">
        {{ old('notes', $editing ? $vehicleCertificate->notes : '') }}</x-input.textarea>

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $vehicleCertificate->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $vehicleCertificate->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            @role('super-admin|manager|supervisor')
                <x-shows.sub-dl>
                    <x-shows.dt>Created By</x-shows.dt>
                    <x-shows.dd>{{ optional($vehicleCertificate->created_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
                @endrole @role('staff|super-admin')
                <x-shows.sub-dl>
                    <x-shows.dt>Updated By</x-shows.dt>
                    <x-shows.dd>{{ optional($vehicleCertificate->approved_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
        </x-shows.dl>
    @endif
</div>
