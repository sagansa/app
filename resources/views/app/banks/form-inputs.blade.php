@php $editing = isset($bank) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.text name="name" label="Name" value="{{ old('name', $editing ? $bank->name : '') }}" maxlength="50"
        placeholder="Name" required></x-input.text>

    <x-input.select name="status" label="Status">
        @php $selected = old('status', ($editing ? $bank->status : '')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }}>active</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }}>inactive</option>
    </x-input.select>

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $bank->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $bank->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
        </x-shows.dl>
    @endif
</div>
