@php $editing = isset($storeCashless) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.select name="cashless_provider_id" label="Cashless Provider" required>
        @php $selected = old('cashless_provider_id', ($editing ? $storeCashless->cashless_provider_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($cashlessProviders as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
            </option>
        @endforeach
    </x-input.select>

    <x-input.select name="store_id" label="Store" required>
        @php $selected = old('store_id', ($editing ? $storeCashless->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($stores as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
            </option>
        @endforeach
    </x-input.select>

    <x-input.email name="email" label="Email" value="{{ old('email', $editing ? $storeCashless->email : '') }}"
        maxlength="255" required></x-input.email>

    <x-input.text name="username" label="Username"
        value="{{ old('username', $editing ? $storeCashless->username : '') }}" maxlength="255" required>
    </x-input.text>

    <x-input.password name="password" label="Password" maxlength="255" :required="!$editing"></x-input.password>

    <x-input.number name="no_telp" label="No Telp"
        value="{{ old('no_telp', $editing ? $storeCashless->no_telp : '') }}" required>
    </x-input.number>

    <x-input.select name="parent_account_cashless_id" label="Parent Account Cashless">
        @php $selected = old('parent_account_cashless_id', ($editing ? $storeCashless->parent_account_cashless_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($parentAccountCashlesses as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
            </option>
        @endforeach
    </x-input.select>

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $storeCashless->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $storeCashless->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
        </x-shows.dl>
    @endif
</div>
