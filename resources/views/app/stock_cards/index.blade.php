<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.stock_cards.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">Kartu stok dibuat setiap hari sebelum gudang buka</p>
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
                @can('create', App\Models\StockCard::class)
                    <a href="{{ route('stock-cards.create') }}">
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
                <x-tables.th-left>@lang('crud.stock_cards.inputs.store_id')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.stock_cards.inputs.date')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.stock_cards.inputs.user_id')</x-tables.th-left-hide>

                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($stockCards as $stockCard)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-main>
                            <x-slot name="main">{{ optional($stockCard->store)->nickname ?? '-' }}</x-slot>
                            <x-slot name="sub">
                                <p>{{ $stockCard->date->toFormattedDate() ?? '-' }}</p>
                                <p> {{ optional($stockCard->user)->name ?? '-' }}</p>
                            </x-slot>

                        </x-tables.td-left-main>
                        <x-tables.td-left-hide>{{ $stockCard->date->toFormattedDate() ?? '-' }}</x-tables.td-left-hide>

                        <x-tables.td-left-hide>{{ optional($stockCard->user)->name ?? '-' }}</x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($stockCard->status != '2')
                                    <a href="{{ route('stock-cards.edit', $stockCard) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($stockCard->status == '2')
                                    <a href="{{ route('stock-cards.show', $stockCard) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $stockCard)
                                <form action="{{ route('stock-cards.destroy', $stockCard) }}" method="POST"
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
<div class="px-4 mt-10">{!! $stockCards->render() !!}</div>
</x-admin-layout>
