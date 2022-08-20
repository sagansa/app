@php $editing = isset($stockCard) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.date name="date" label="Date"
        value="{{ old('date', $editing ? optional($stockCard->date)->format('Y-m-d') : '') }}" required></x-input.date>

    <x-input.select name="store_id" label="Store" required>
        @php $selected = old('store_id', ($editing ? $stockCard->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($stores as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $stockCard->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $stockCard->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created By</x-shows.dt>
                <x-shows.dd>{{ optional($stockCard->user)->name ?? '-' }}
                </x-shows.dd>
            </x-shows.sub-dl>
        </x-shows.dl>
    @endif
</div>
