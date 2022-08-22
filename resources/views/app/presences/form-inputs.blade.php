@php $editing = isset($presence) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.select name="closing_store_id" label="Closing Store" required>
        @php $selected = old('closing_store_id', ($editing ? $presence->closing_store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($closingStores as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.number name="amount" label="Amount" value="{{ old('amount', $editing ? $presence->amount : '') }}" required>
    </x-input.number>

    <x-input.select name="payment_type_id" label="Payment Type" required>
        @php $selected = old('payment_type_id', ($editing ? $presence->payment_type_id : '1')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($paymentTypes as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    @role('super-admin')
        <x-input.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $presence->status : '1')) @endphp
            <option value="1" {{ $selected == '1' ? 'selected' : '' }}>process</option>
            <option value="2" {{ $selected == '2' ? 'selected' : '' }}>done</option>
            <option value="3" {{ $selected == '3' ? 'selected' : '' }}>no need</option>
        </x-input.select>
        <x-input.select name="created_by_id" label="Created By">
            @php $selected = old('created_by_id', ($editing ? $presence->created_by_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            @foreach ($users as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-input.select>
    @endrole

    @role('supervisor|manager|staff')
        <x-input.hidden name="status" value="{{ old('status', $editing ? $presence->status : '1') }}">
        </x-input.hidden>
    @endrole

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $presence->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $presence->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            @role('super-admin|manager|supervisor')
                <x-shows.sub-dl>
                    <x-shows.dt>Created By</x-shows.dt>
                    <x-shows.dd>{{ optional($presence->created_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
                @endrole @role('staff|super-admin')
                <x-shows.sub-dl>
                    <x-shows.dt>Updated By</x-shows.dt>
                    <x-shows.dd>{{ optional($presence->approved_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
        </x-shows.dl>
    @endif
</div>
