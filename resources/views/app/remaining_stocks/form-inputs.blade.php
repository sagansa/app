@php $editing = isset($remainingStock) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    @role('staff|super-admin|manager')
        <x-input.date name="date" label="Date"
            value="{{ old('date', $editing ? optional($remainingStock->date)->format('Y-m-d') : '') }}" required>
        </x-input.date>

        <x-input.select name="store_id" label="Store" required>
            @php $selected = old('store_id', ($editing ? $remainingStock->store_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            @foreach ($stores as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </x-input.select>
    @endrole

    @role('supervisor')
        <x-input.hidden name="store_id" value="{{ old('result', $editing ? $remainingStock->store_id : '') }}">
        </x-input.hidden>

        <x-input.hidden name="date"
            value="{{ old('date', $editing ? optional($remainingStock->date)->format('Y-m-d') : '') }}">
        </x-input.hidden>
    @endrole

    @if ($editing)
        @role('manager|supervisor|super-admin')
            <x-input.select name="status" label="Status">
                @php $selected = old('status', ($editing ? $remainingStock->status : '1')) @endphp
                <option disabled value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diperiksa</option>
                <option value="2" {{ $selected == '2' ? 'selected' : '' }}>valid</option>
                <option value="3" {{ $selected == '3' ? 'selected' : '' }}>perbaiki</option>
                <option disabled value="4" {{ $selected == '4' ? 'selected' : '' }}>periksa ulang</option>
            </x-input.select>
        @endrole

        @role('staff')
            @if ($remainingStock->approved_by_id != null)
                <x-input.select name="status" label="Status">
                    @php $selected = old('status', ($editing ? $remainingStock->status : '1')) @endphp
                    <option disabled value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diperiksa</option>
                    <option disabled value="3" {{ $selected == '3' ? 'selected' : '' }}>perbaiki</option>
                    <option value="4" {{ $selected == '4' ? 'selected' : '' }}>periksa ulang</option>
                </x-input.select>
            @else
                <x-input.hidden name="status" value="{{ old('status', $editing ? $remainingStock->status : '1') }}">
                </x-input.hidden>
            @endif
        @endrole
    @endif

    @if (!$editing)
        <x-input.hidden name="status" value="{{ old('status', $editing ? $remainingStock->status : '1') }}">
        </x-input.hidden>
    @endif

    <x-input.textarea name="notes" label="Notes">{{ old('notes', $editing ? $remainingStock->notes : '') }}
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
            @role('supervisor')
                <x-shows.sub-dl>
                    <x-shows.dt>Store</x-shows.dt>
                    <x-shows.dd>{{ $remainingStock->store->nickname }} </x-shows.dd>
                </x-shows.sub-dl>
                <x-shows.sub-dl>
                    <x-shows.dt>Date</x-shows.dt>
                    <x-shows.dd>{{ $remainingStock->date->toFormattedDate() }} </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $remainingStock->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $remainingStock->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            @role('super-admin|manager|supervisor')
                <x-shows.sub-dl>
                    <x-shows.dt>Created By</x-shows.dt>
                    <x-shows.dd>{{ optional($remainingStock->created_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
                @endrole @role('staff|super-admin')
                <x-shows.sub-dl>
                    <x-shows.dt>Approved By</x-shows.dt>
                    <x-shows.dd>{{ optional($remainingStock->approved_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
        </x-shows.dl>
    @endif
</div>
