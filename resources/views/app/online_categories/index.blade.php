<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.online_categories.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">daftar kategori produk yang dijual online</p>
    </x-slot>

    <div class="mt-4 mb-5">
        <div class="flex flex-wrap justify-between mt-1">
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
            <div class="text-right md:w-1/3">
                @can('create', App\Models\OnlineCategory::class)
                    <a href="{{ route('online-categories.create') }}">
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
                <x-tables.th-left>@lang('crud.online_categories.inputs.name')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.online_categories.inputs.status')</x-tables.th-left>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($onlineCategories as $onlineCategory)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>{{ $onlineCategory->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $onlineCategory->status_badge }}">
                                {{ $onlineCategory->status_name }}
                            </x-spans.status-valid>
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('edit', $onlineCategory)
                                    <a href="{{ route('online-categories.edit', $onlineCategory) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @endcan
                                @can('delete', $onlineCategory)
                                    <form action="{{ route('online-categories.destroy', $onlineCategory) }}"
                                        method="POST" onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                        @csrf @method('DELETE')
                                        <x-buttons.delete></x-buttons.delete>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">@lang('crud.common.no_items_found')</td>
                    </tr>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="px-4 mt-10">{!! $onlineCategories->render() !!}</div>
</x-admin-layout>
