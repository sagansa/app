@php $editing = isset($hygiene) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">

    @role('staff|super-admin|manager')
        <x-input.select name="store_id" label="Store" required>
            @php $selected = old('store_id', ($editing ? $hygiene->store_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            @foreach ($stores as $value => $label)
                @role('staff|super-admin|manager')
                    <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                    </option>
                @else
                    <option disabled value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endrole
            @endforeach
        </x-input.select>
    @endrole

    @role('supervisor')
        <x-input.hidden name="store_id" value="{{ old('result', $editing ? $hygiene->store_id : '') }}">
        </x-input.hidden>
    @endrole

    @if ($editing)
        @role('manager|supervisor|super-admin')
            <x-input.select name="status" label="Status">
                @php $selected = old('status', ($editing ? $hygiene->status : '')) @endphp
                <option disabled value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diperiksa</option>
                <option value="2" {{ $selected == '2' ? 'selected' : '' }}>valid</option>
                <option value="3" {{ $selected == '3' ? 'selected' : '' }}>perbaiki</option>
                <option disabled value="4" {{ $selected == '4' ? 'selected' : '' }}>periksa ulang</option>
            </x-input.select>
        @endrole

        @role('staff')
            @if ($hygiene->approved_by_id != null)
                <x-input.select name="status" label="Status">
                    @php $selected = old('status', ($editing ? $hygiene->status : '1')) @endphp
                    <option disabled value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diperiksa</option>
                    <option disabled value="2" {{ $selected == '2' ? 'selected' : '' }}>valid</option>
                    <option disabled value="3" {{ $selected == '3' ? 'selected' : '' }}>perbaiki</option>
                    <option value="4" {{ $selected == '4' ? 'selected' : '' }}>periksa ulang</option>
                </x-input.select>
            @else
                <x-input.hidden name="status" value="{{ old('status', $editing ? $hygiene->status : '1') }}">
                </x-input.hidden>
            @endif
        @endrole
    @endif

    <x-input.textarea name="notes" label="Notes">{{ old('notes', $editing ? $hygiene->notes : '') }}
    </x-input.textarea>

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $hygiene->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $hygiene->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            @role('manager|supervisor|super-admin')
                <x-shows.sub-dl>
                    <x-shows.dt>@lang('crud.hygienes.inputs.created_by_id')</x-shows.dt>
                    <x-shows.dd>{{ optional($hygiene->created_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
            @role('staff|super-admin')
                <x-shows.sub-dl>
                    <x-shows.dt>@lang('crud.hygienes.inputs.approved_by_id')</x-shows.dt>
                    <x-shows.dd>{{ optional($hygiene->approved_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
        </x-shows.dl>
    @endif
</div>
