<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.stores.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('stores.index') }}" class="mr-4"><i class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.stores.inputs.name')</x-shows.dt>
                        <x-shows.dd>{{ $store->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.stores.inputs.nickname')</x-shows.dt>
                        <x-shows.dd>{{ $store->nickname ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.stores.inputs.no_telp')</x-shows.dt>
                        <x-shows.dd>{{ $store->no_telp ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.stores.inputs.email')</x-shows.dt>
                        <x-shows.dd>{{ $store->email ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.stores.inputs.status')</x-shows.dt>
                        <x-shows.dd>
                            @if ($store->status == 1)
                                <p>warung</p>
                            @elseif ($store->status == 2)
                                <p>gudang</p>
                            @elseif ($store->status == 3)
                                <p>produksi</p>
                            @elseif ($store->status == 4)
                                <p>warung + gudang</p>
                            @elseif ($store->status == 5)
                                <p>warung + produksi</p>
                            @elseif ($store->status == 6)
                                <p>gudang + produksi</p>
                            @elseif ($store->status == 7)
                                <p>warung + gudang + produksi</p>
                            @elseif ($store->status == 8)
                                <p>tidak aktif</p>
                            @endif
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd>{{ $store->created_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd>{{ $store->updated_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('stores.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @can('view-any', App\Models\ContractLocation::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title"> Contract Locations </x-slot>

                    <livewire:store-contract-locations :store="$store" />
                </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
