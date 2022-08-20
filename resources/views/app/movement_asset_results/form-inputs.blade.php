@php $editing = isset($movementAssetResult) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.select name="store_id" label="Store" required>
        @php $selected = old('store_id', ($editing ? $movementAssetResult->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($stores as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.date
        name="date"
        label="Date"
        value="{{ old('date', ($editing ? optional($movementAssetResult->date)->format('Y-m-d') : '')) }}"
        max="255"
        required
    ></x-input.date>

    <x-input.text
        name="status"
        label="Status"
        value="{{ old('status', ($editing ? $movementAssetResult->status : '')) }}"
        maxlength="255"
        placeholder="Status"
        required
    ></x-input.text>

    <x-input.textarea name="notes" label="Notes" maxlength="255"
        >{{ old('notes', ($editing ? $movementAssetResult->notes : ''))
        }}</x-input.textarea
    >

    <x-input.select name="user_id" label="User">
        @php $selected = old('user_id', ($editing ? $movementAssetResult->user_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
        @foreach($users as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    @if ($editing)
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>Created Date</x-shows.dt>
            <x-shows.dd>{{ $movementAssetResult->created_at }} </x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Updated Date</x-shows.dt>
            <x-shows.dd>{{ $movementAssetResult->updated_at }} </x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager|supervisor')
        <x-shows.sub-dl>
            <x-shows.dt>Created By</x-shows.dt>
            <x-shows.dd
                >{{ optional($movementAssetResult->created_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole @role('staff|super-admin')
        <x-shows.sub-dl>
            <x-shows.dt>Updated By</x-shows.dt>
            <x-shows.dd
                >{{ optional($movementAssetResult->approved_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
    @endif
</div>
