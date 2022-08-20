@php $editing = isset($parentAccountCashless) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.select name="cashless_provider_id" label="Cashless Provider" required>
        @php $selected = old('cashless_provider_id', ($editing ? $parentAccountCashless->cashless_provider_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($cashlessProviders as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
            </option>
        @endforeach
    </x-input.select>

    <x-input.text name="username" label="Username"
        value="{{ old('username', $editing ? $parentAccountCashless->username : '') }}" maxlength="255">
    </x-input.text>

    <x-input.password name="password" label="Password" maxlength="255" placeholder="Password"></x-input.password>

    <x-input.email name="email" label="Email"
        value="{{ old('email', $editing ? $parentAccountCashless->email : '') }}" maxlength="255" placeholder="Email">
    </x-input.email>

    <x-input.number name="no_telp" label="No Telp"
        value="{{ old('no_telp', $editing ? $parentAccountCashless->no_telp : '') }}" placeholder="No Telp">
    </x-input.number>

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $parentAccountCashless->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $parentAccountCashless->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
        </x-shows.dl>
    @endif
</div>
