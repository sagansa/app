@php $editing = isset($userCashless) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.select name="admin_cashless_id" label="Admin Cashless">
        @php $selected = old('admin_cashless_id', ($editing ? $userCashless->admin_cashless_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($adminCashlesses as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="store_id" label="Store">
        @php $selected = old('store_id', ($editing ? $userCashless->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($stores as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.email
        name="email"
        label="Email"
        value="{{ old('email', ($editing ? $userCashless->email : '')) }}"
        maxlength="255"
    ></x-input.email>

    <x-input.text
        name="username"
        label="Username"
        value="{{ old('username', ($editing ? $userCashless->username : '')) }}"
        maxlength="50"
    ></x-input.text>

    <x-input.number
        name="no_telp"
        label="No Telp"
        value="{{ old('no_telp', ($editing ? $userCashless->no_telp : '')) }}"
    ></x-input.number>

    <x-input.text
        name="password"
        label="Password"
        value="{{ old('password', ($editing ? $userCashless->password : '')) }}"
        maxlength="255"
    ></x-input.text>

    @if ($editing)
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>Created Date</x-shows.dt>
            <x-shows.dd>{{ $userCashless->created_at }} </x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Updated Date</x-shows.dt>
            <x-shows.dd>{{ $userCashless->updated_at }} </x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager|supervisor')
        <x-shows.sub-dl>
            <x-shows.dt>Created By</x-shows.dt>
            <x-shows.dd
                >{{ optional($userCashless->created_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole @role('staff|super-admin')
        <x-shows.sub-dl>
            <x-shows.dt>Updated By</x-shows.dt>
            <x-shows.dd
                >{{ optional($userCashless->approved_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
    @endif
</div>
