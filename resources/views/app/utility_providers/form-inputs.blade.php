@php $editing = isset($utilityProvider) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.text
        name="name"
        label="Name"
        value="{{ old('name', ($editing ? $utilityProvider->name : '')) }}"
        maxlength="20"
        required
    ></x-input.text>

    <x-input.select name="category" label="Category">
        @php $selected = old('category', ($editing ? $utilityProvider->category : '1')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >listrik</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >air</option>
        <option value="3" {{ $selected == '3' ? 'selected' : '' }} >internet</option>
    </x-input.select>

    @if ($editing)
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>Created Date</x-shows.dt>
            <x-shows.dd>{{ $utilityProvider->created_at }} </x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Updated Date</x-shows.dt>
            <x-shows.dd>{{ $utilityProvider->updated_at }} </x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager|supervisor')
        <x-shows.sub-dl>
            <x-shows.dt>Created By</x-shows.dt>
            <x-shows.dd
                >{{ optional($utilityProvider->created_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole @role('staff|super-admin')
        <x-shows.sub-dl>
            <x-shows.dt>Updated By</x-shows.dt>
            <x-shows.dd
                >{{ optional($utilityProvider->approved_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
    @endif
</div>
