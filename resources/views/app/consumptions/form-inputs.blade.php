@php $editing = isset($consumption) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.select name="store_id" label="Store" required>
        @php $selected = old('store_id', ($editing ? $consumption->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($stores as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.date name="date" label="Date"
        value="{{ old('date', $editing ? optional($consumption->date)->format('Y-m-d') : '') }}" required>
    </x-input.date>

    <x-input.select name="status" label="Status">
        @php $selected = old('status', ($editing ? $consumption->status : '1')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diperiksa</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }}>valid</option>
        <option value="3" {{ $selected == '3' ? 'selected' : '' }}>perbaiki</option>
        <option value="4" {{ $selected == '4' ? 'selected' : '' }}>periksa ulang</option>
    </x-input.select>

    <x-input.textarea name="notes" label="Notes">{{ old('notes', $editing ? $consumption->notes : '') }}
    </x-input.textarea>

    <div class="md:grid md:grid-cols-4 md:gap-6">
        <div class="md:col-span-1">

        </div>
        <div class="mt-5 md:col-span-3 md:mt-0">
            @include('app.products.products')
        </div>
    </div>

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $consumption->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $consumption->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            @role('super-admin|manager|supervisor')
                <x-shows.sub-dl>
                    <x-shows.dt>Created By</x-shows.dt>
                    <x-shows.dd>{{ optional($consumption->created_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
                @endrole @role('staff|super-admin')
                <x-shows.sub-dl>
                    <x-shows.dt>Updated By</x-shows.dt>
                    <x-shows.dd>{{ optional($consumption->approved_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
        </x-shows.dl>
    @endif
</div>
