@php $editing = isset($store) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.text
        name="nickname"
        label="Nickname"
        value="{{ old('nickname', ($editing ? $store->nickname : '')) }}"
        maxlength="255"
        placeholder="Nickname"
        required
    ></x-input.text>

    <x-input.text
        name="name"
        label="Name"
        value="{{ old('name', ($editing ? $store->name : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.number
        name="no_telp"
        label="No Telp"
        value="{{ old('no_telp', ($editing ? $store->no_telp : '')) }}"
    ></x-input.number>

    <x-input.email
        name="email"
        label="Email"
        value="{{ old('email', ($editing ? $store->email : '')) }}"
        maxlength="255"
        required
    ></x-input.email>

    <x-input.select name="status" label="Status">
        @php $selected = old('status', ($editing ? $store->status : '')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >warung</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >gudang</option>
        <option value="3" {{ $selected == '3' ? 'selected' : '' }} >produksi</option>
        <option value="4" {{ $selected == '4' ? 'selected' : '' }} >warung + gudang</option>
        <option value="5" {{ $selected == '5' ? 'selected' : '' }} >warung + produksi</option>
        <option value="6" {{ $selected == '6' ? 'selected' : '' }} >gudang + produksi</option>
        <option value="7" {{ $selected == '7' ? 'selected' : '' }} >warung + gudang + produksi</option>
        <option value="8" {{ $selected == '8' ? 'selected' : '' }} >tidak aktif</option>
    </x-input.select>

    @if ($editing)
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>Created Date</x-shows.dt>
            <x-shows.dd>{{ $store->created_at }} </x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Updated Date</x-shows.dt>
            <x-shows.dd>{{ $store->updated_at }} </x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager|supervisor')
        <x-shows.sub-dl>
            <x-shows.dt>Created By</x-shows.dt>
            <x-shows.dd
                >{{ optional($store->created_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole @role('staff|super-admin')
        <x-shows.sub-dl>
            <x-shows.dt>Updated By</x-shows.dt>
            <x-shows.dd
                >{{ optional($store->approved_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
    @endif
</div>
