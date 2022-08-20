@php $editing = isset($adminCashless) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.select
        name="cashless_provider_id"
        label="Cashless Provider"
        required
    >
        @php $selected = old('cashless_provider_id', ($editing ? $adminCashless->cashless_provider_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($cashlessProviders as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.text
        name="username"
        label="Username"
        value="{{ old('username', ($editing ? $adminCashless->username : '')) }}"
        maxlength="50"
    ></x-input.text>

    <x-input.email
        name="email"
        label="Email"
        value="{{ old('email', ($editing ? $adminCashless->email : '')) }}"
        maxlength="255"
    ></x-input.email>

    <x-input.number
        name="no_telp"
        label="No Telp"
        value="{{ old('no_telp', ($editing ? $adminCashless->no_telp : '')) }}"
    ></x-input.number>

    <x-input.text
        name="password"
        label="Password"
        value="{{ old('password', ($editing ? $adminCashless->password : '')) }}"
        maxlength="255"
    ></x-input.text>

    @if ($editing)
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>Created Date</x-shows.dt>
            <x-shows.dd>{{ $adminCashless->created_at }} </x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Updated Date</x-shows.dt>
            <x-shows.dd>{{ $adminCashless->updated_at }} </x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager|supervisor')
        <x-shows.sub-dl>
            <x-shows.dt>Created By</x-shows.dt>
            <x-shows.dd
                >{{ optional($adminCashless->created_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole @role('staff|super-admin')
        <x-shows.sub-dl>
            <x-shows.dt>Updated By</x-shows.dt>
            <x-shows.dd
                >{{ optional($adminCashless->approved_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
    @endif
</div>
