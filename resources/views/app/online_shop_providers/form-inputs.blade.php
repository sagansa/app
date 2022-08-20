@php $editing = isset($onlineShopProvider) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.text name="name" label="Name" value="{{ old('name', $editing ? $onlineShopProvider->name : '') }}"
        maxlength="20" required></x-input.text>

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $onlineShopProvider->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $onlineShopProvider->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
        </x-shows.dl>
    @endif
</div>
