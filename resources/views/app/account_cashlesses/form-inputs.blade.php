@php $editing = isset($accountCashless) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.select name="cashless_provider_id" label="Cashless Provider" required>
        @php $selected = old('cashless_provider_id', ($editing ? $accountCashless->cashless_provider_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($cashlessProviders as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="store_id" label="Store" required>
        @php $selected = old('store_id', ($editing ? $accountCashless->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($stores as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="store_cashless_id" label="Store Cashless" required>
        @php $selected = old('store_cashless_id', ($editing ? $accountCashless->store_cashless_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($storeCashlesses as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
            </option>
        @endforeach
    </x-input.select>

    <x-input.email name="email" label="Email" value="{{ old('email', $editing ? $accountCashless->email : '') }}">
    </x-input.email>

    <x-input.text name="username" label="Username"
        value="{{ old('username', $editing ? $accountCashless->username : '') }}"></x-input.text>

    <x-input.text name="password" label="Password"
        value="{{ old('password', $editing ? $accountCashless->password : '') }}"></x-input.text>

    <x-input.text name="no_telp" label="No Telp"
        value="{{ old('no_telp', $editing ? $accountCashless->no_telp : '') }}"></x-input.text>

    <x-input.select name="status" label="Status">
        @php $selected = old('status', ($editing ? $accountCashless->status : '1')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }}>active</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }}>inactive</option>
    </x-input.select>

    <x-input.textarea name="notes" label="Notes" maxlength="255">
        {{ old('notes', $editing ? $accountCashless->notes : '') }}</x-input.textarea>

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $accountCashless->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $accountCashless->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            @role('super-admin|manager|supervisor')
                <x-shows.sub-dl>
                    <x-shows.dt>Created By</x-shows.dt>
                    <x-shows.dd>{{ optional($accountCashless->created_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
                @endrole @role('staff|super-admin')
                <x-shows.sub-dl>
                    <x-shows.dt>Updated By</x-shows.dt>
                    <x-shows.dd>{{ optional($accountCashless->approved_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
        </x-shows.dl>
    @endif
</div>
