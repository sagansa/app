<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.stores.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">daftar seluruh cabang</p>
    </x-slot>

    <div class="mt-4 mb-5">
        <div class="flex flex-wrap justify-between">
            <div class="md:w-1/3">
                <form>
                    <div class="flex items-center w-full">
                        <x-inputs.text name="search" value="{{ $search ?? '' }}"
                            placeholder="{{ __('crud.common.search') }}" autocomplete="off"></x-inputs.text>

                        <div class="ml-1">
                            <x-jet-button>
                                <i class="icon ion-md-search"></i>
                            </x-jet-button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="text-right md:w-1/2">
                @can('create', App\Models\Store::class)
                    <a href="{{ route('stores.create') }}">
                        <x-jet-button>
                            <i class="mr-1 icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </x-jet-button>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <x-tables.th-left-hide>id</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.stores.inputs.name')</x-tables.th-left-hide>
                <x-tables.th-left>@lang('crud.stores.inputs.nickname')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.stores.inputs.no_telp')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.stores.inputs.email')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.stores.inputs.status')</x-tables.th-left-hide>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($stores as $store)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>{{ $store->id ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $store->name ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-main>
                            <x-slot name="main">{{ $store->nickname ?? '-' }}</x-slot>
                            <x-slot name="sub">
                                <p>{{ $store->id }} - {{ $store->name ?? '-' }}</p>
                                <p>{{ $store->no_telp ?? '-' }}</p>
                                <p>{{ $store->email ?? '-' }}</p>
                                <p>
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
                                </p>
                            </x-slot>
                        </x-tables.td-left-main>
                        <x-tables.td-right-hide>{{ $store->no_telp ?? '-' }}</x-tables.td-right-hide>
                        <x-tables.td-left-hide>{{ $store->email ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>
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
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('edit', $store)
                                    <a href="{{ route('stores.edit', $store) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @endcan
                                @can('delete', $store)
                                    <form action="{{ route('stores.destroy', $store) }}" method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                        @csrf @method('DELETE')
                                        <x-buttons.delete></x-buttons.delete>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">@lang('crud.common.no_items_found')</td>
                    </tr>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="px-4 mt-10">{!! $stores->render() !!}</div>
</x-admin-layout>
