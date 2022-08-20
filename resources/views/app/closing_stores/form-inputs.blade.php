@php $editing = isset($closingStore) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.select name="store_id" label="Store" required>
        @php $selected = old('store_id', ($editing ? $closingStore->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($stores as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="shift_store_id" label="Shift Store" required>
        @php $selected = old('shift_store_id', ($editing ? $closingStore->shift_store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($shiftStores as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.date name="date" label="Date"
        value="{{ old('date', $editing ? optional($closingStore->date)->format('Y-m-d') : '') }}" required>
    </x-input.date>

    {{-- <x-input.number name="cash_from_yesterday" label="Cash From Yesterday"
        value="{{ old('cash_from_yesterday', $editing ? $closingStore->cash_from_yesterday : '') }}" required>
    </x-input.number> --}}

    <x-input.hidden name="cash_from_yesterday"
        value="{{ old('cash_from_yesterday', $editing ? $closingStore->cash_from_yesterday : '0') }}" required>
    </x-input.hidden>

    {{-- <x-input.number name="cash_for_tomorrow" label="Cash For Tomorrow"
        value="{{ old('cash_for_tomorrow', $editing ? $closingStore->cash_for_tomorrow : '') }}" required>
    </x-input.number> --}}

    <x-input.hidden name="cash_for_tomorrow"
        value="{{ old('cash_for_tomorrow', $editing ? $closingStore->cash_for_tomorrow : '0') }}" required>
    </x-input.hidden>

    {{-- <x-input.select name="transfer_by_id" label="Transfer By" required>
        @php $selected = old('transfer_by_id', ($editing ? $closingStore->transfer_by_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
            </option>
        @endforeach
    </x-input.select> --}}

    <x-input.hidden name="transfer_by_id"
        value="{{ old('transfer_by_id', $editing ? $closingStore->transfer_by_id : '1') }}" required>
    </x-input.hidden>

    {{-- <x-input.number name="total_cash_transfer" label="Total Cash Transfer"
        value="{{ old('total_cash_transfer', $editing ? $closingStore->total_cash_transfer : '') }}" required>
    </x-input.number> --}}

    <x-input.hidden name="total_cash_transfer"
        value="{{ old('total_cash_transfer', $editing ? $closingStore->total_cash_transfer : '0') }}" required>
    </x-input.hidden>

    @role('super-admin')
        <x-input.select name="status" label="Closing Status">
            @php $selected = old('status', ($editing ? $closingStore->closing_status : '')) @endphp
            <option value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diperiksa</option>
            <option value="2" {{ $selected == '2' ? 'selected' : '' }}>valid</option>
            <option value="3" {{ $selected == '3' ? 'selected' : '' }}>perbaiki</option>
            <option value="4" {{ $selected == '4' ? 'selected' : '' }}>periksa ulang</option>
        </x-input.select>
    @endrole

    @role('staff|supervisor')
        <x-input.hidden name="status" value="{{ old('status', $editing ? $closingStore->status : '1') }}">
        </x-input.hidden>
    @endrole

    {{-- @if ($editing)
        <x-input.select name="approved_by_id" label="Approved By">
            @php $selected = old('approved_by_id', ($editing ? $closingStore->approved_by_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            @foreach ($users as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-input.select>
    @endif --}}

    <x-input.textarea name="notes" label="Notes">{{ old('notes', $editing ? $closingStore->notes : '') }}
    </x-input.textarea>

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $closingStore->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $closingStore->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            @role('super-admin|manager|supervisor')
                <x-shows.sub-dl>
                    <x-shows.dt>Created By</x-shows.dt>
                    <x-shows.dd>{{ optional($closingStore->created_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
                @endrole @role('staff|super-admin')
                <x-shows.sub-dl>
                    <x-shows.dt>Updated By</x-shows.dt>
                    <x-shows.dd>{{ optional($closingStore->approved_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
        </x-shows.dl>
    @endif
</div>
