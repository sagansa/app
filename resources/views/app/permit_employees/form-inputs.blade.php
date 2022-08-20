@php $editing = isset($permitEmployee) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.select name="reason" label="Reason">
        @php $selected = old('reason', ($editing ? $permitEmployee->reason : '2')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }}>menikah</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }}>sakit</option>
        <option value="3" {{ $selected == '3' ? 'selected' : '' }}>pulkam</option>
        <option value="4" {{ $selected == '4' ? 'selected' : '' }}>libur</option>
        <option value="5" {{ $selected == '5' ? 'selected' : '' }}>keluarga meninggal</option>
        <option value="6" {{ $selected == '4' ? 'selected' : '' }}>libur</option>
    </x-input.select>

    <x-input.date name="from_date" label="From Date"
        value="{{ old('from_date', $editing ? optional($permitEmployee->from_date)->format('Y-m-d') : '') }}"
        max="255" required></x-input.date>

    <x-input.date name="until_date" label="Until Date"
        value="{{ old('until_date', $editing ? optional($permitEmployee->until_date)->format('Y-m-d') : '') }}"
        max="255" required></x-input.date>

    <x-input.textarea name="notes" label="Notes">
        {{ old('notes', $editing ? $permitEmployee->notes : '') }}</x-input.textarea>

    @role('super-admin')
        <x-input.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $permitEmployee->status : '1')) @endphp
            <option disabled value="1" {{ $selected == '1' ? 'selected' : '' }}>belum disetujui</option>
            <option value="2" {{ $selected == '2' ? 'selected' : '' }}>disetujui</option>
            <option value="3" {{ $selected == '3' ? 'selected' : '' }}>tidak disetujui</option>
            <option disabled value="4" {{ $selected == '4' ? 'selected' : '' }}>pengajuan ulang</option>
        </x-input.select>

        <x-input.select name="created_by_id" label="Created By">
            @php $selected = old('created_by_id', ($editing ? $permitEmployee->created_by_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            @foreach ($users as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-input.select>
    @endrole

    @role('manager|supervisor|staff')
        <x-input.hidden name="status" value="{{ old('result', $editing ? $permitEmployee->status : '1') }}">
        </x-input.hidden>

        <x-input.hidden name="created_by_id" value="{{ old('result', $editing ? $permitEmployee->created_by_id : '') }}">
        </x-input.hidden>
    @endrole

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $permitEmployee->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $permitEmployee->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            @role('staff|manager|supervisor')
                <x-shows.sub-dl>
                    <x-shows.dt>Status</x-shows.dt>
                    <x-shows.dd>
                        @if ($permitEmployee->status == '1')
                            <x-spans.yellow>belum disetujui</x-spans.yellow>
                        @elseif ($permitEmployee->status == '2')
                            <x-spans.green>disetujui</x-spans.green>
                        @elseif ($permitEmployee->status == '3')
                            <x-spans.red>tidak disetujui</x-spans.red>
                        @elseif ($permitEmployee->status == '4')
                            <x-spans.gray>pengajuan ulang</x-spans.gray>
                        @endif
                    </x-shows.dd>
                </x-shows.sub-dl>
                <x-shows.sub-dl>
                    <x-shows.dt>Created By</x-shows.dt>
                    <x-shows.dd>{{ optional($permitEmployee->created_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
        </x-shows.dl>
    @endif
</div>
