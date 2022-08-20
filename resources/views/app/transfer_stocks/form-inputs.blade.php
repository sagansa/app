@php $editing = isset($transferStock) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.date name="date" label="Date"
        value="{{ old('date', $editing ? optional($transferStock->date)->format('Y-m-d') : '') }}" required>
    </x-input.date>

    <x-input.select name="from_store_id" label="From Store" required>
        @php $selected = old('from_store_id', ($editing ? $transferStock->from_store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($stores as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="to_store_id" label="To Store" required>
        @php $selected = old('to_store_id', ($editing ? $transferStock->to_store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($stores as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    {{-- <x-input.select name="status" label="Status">
        @php $selected = old('status', ($editing ? $transferStock->status : '1')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diperiksa</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }}>valid</option>
        <option value="3" {{ $selected == '3' ? 'selected' : '' }}>perbaiki</option>
        <option value="4" {{ $selected == '4' ? 'selected' : '' }}>periksa ulang</option>
    </x-input.select> --}}

    @if ($editing)
        @role('manager|supervisor|super-admin')
            <x-input.select name="status" label="Status">
                @php $selected = old('status', ($editing ? $transferStock->status : '1')) @endphp
                <option disabled value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diperiksa</option>
                <option value="2" {{ $selected == '2' ? 'selected' : '' }}>valid</option>
                <option value="3" {{ $selected == '3' ? 'selected' : '' }}>perbaiki</option>
                <option disabled value="4" {{ $selected == '4' ? 'selected' : '' }}>periksa ulang</option>
            </x-input.select>
        @endrole

        @role('staff')
            @if ($transferStock->approved_by_id != null)
                <x-input.select name="status" label="Status">
                    @php $selected = old('status', ($editing ? $transferStock->status : '1')) @endphp
                    <option disabled value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diperiksa</option>
                    <option disabled value="3" {{ $selected == '3' ? 'selected' : '' }}>perbaiki</option>
                    <option value="4" {{ $selected == '4' ? 'selected' : '' }}>periksa ulang</option>
                </x-input.select>
            @else
                <x-input.hidden name="status" value="{{ old('status', $editing ? $transferStock->status : '1') }}">
                </x-input.hidden>
            @endif
        @endrole
    @endif

    @if (!$editing)
        <x-input.hidden name="status" value="{{ old('status', $editing ? $transferStock->status : '1') }}">
        </x-input.hidden>
    @endif
    <x-input.select name="received_by_id" label="Received By" required>
        @php $selected = old('received_by_id', ($editing ? $transferStock->received_by_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
            </option>
        @endforeach
    </x-input.select>

    <x-input.select name="sent_by_id" label="Sent By" required>
        @php $selected = old('sent_by_id', ($editing ? $transferStock->sent_by_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
            </option>
        @endforeach
    </x-input.select>

    <x-input.textarea name="notes" label="Notes">{{ old('notes', $editing ? $transferStock->notes : '') }}
    </x-input.textarea>

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $transferStock->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $transferStock->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            @role('staff|super-admin')
                <x-shows.sub-dl>
                    <x-shows.dt>Approved By</x-shows.dt>
                    <x-shows.dd>{{ optional($transferStock->approved_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
        </x-shows.dl>
    @endif
</div>
