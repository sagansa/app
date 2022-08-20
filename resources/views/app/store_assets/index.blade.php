<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.store_assets.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">data seluruh aset bergerak</p>
    </x-slot>

    <div class="mt-4 mb-5">
        <div class="flex flex-wrap justify-between mt-1">
            <div class="mt-1 md:w-1/3">
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
            <div class="mt-1 text-right md:w-1/3">
                @can('create', App\Models\StoreAsset::class)
                    <a href="{{ route('store-assets.create') }}">
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
                <x-tables.th-left>@lang('crud.store_assets.inputs.store_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.store_assets.inputs.status')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.store_assets.inputs.notes')</x-tables.th-left>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($storeAssets as $storeAsset)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>{{ optional($storeAsset->store)->nickname ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $storeAsset->status_badge }}">
                                {{ $storeAsset->status_name }}
                            </x-spans.status-valid>
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $storeAsset->notes ?? '-' }}</x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @role('super-admin|manager')
                                    <a href="{{ route('store-assets.edit', $storeAsset) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @endrole
                                @role('staff|supervisor')
                                    <a href="{{ route('store-assets.show', $storeAsset) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endrole
                                @can('delete', $storeAsset)
                                    <form action="{{ route('store-assets.destroy', $storeAsset) }}" method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                        @csrf @method('DELETE')
                                        <x-buttons.delete></x-buttons.delete>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <x-tables.no-items-found colspan="4"> </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="px-4 mt-10">{!! $storeAssets->render() !!}</div>
</x-admin-layout>
