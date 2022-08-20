<x-admin-layout>
    {{-- <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.closing_stores.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">dilaksanakan setiap hari setelah tutup shift</p>
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
                @can('create', App\Models\ClosingStore::class)
                    <a href="{{ route('closing-stores.create') }}">
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
                <x-tables.th-left>@lang('crud.closing_stores.inputs.store_id')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.closing_stores.inputs.date')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.closing_stores.inputs.cash_from_yesterday')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.closing_stores.inputs.cash_for_tomorrow')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.closing_stores.inputs.total_cash_transfer')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.closing_stores.inputs.transfer_by_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.closing_stores.inputs.closing_status')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.closing_stores.inputs.transfer_status')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.closing_stores.inputs.created_by_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.closing_stores.inputs.approved_by_id')</x-tables.th-left-hide>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($closingStores as $closingStore)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-main>
                            <x-slot name="main">{{ optional($closingStore->store)->nickname ?? '-' }} -
                                {{ optional($closingStore->shiftStore)->name ?? '-' }}</x-slot>
                            <x-slot name="sub">
                                <p>{{ $closingStore->date->toFormattedDate() ?? '-' }}</p>
                                <p>{{ optional($closingStore->transfer_by)->name ?? '-' }} - @currency($closingStore->total_cash_transfer)</p>
                                <p>tunai kemarin: @currency($closingStore->cash_from_yesterday)</p>
                                <p>tunai untuk besok: @currency($closingStore->cash_for_tomorrow)</p>

                            </x-slot>
                        </x-tables.td-left-main>
                        <x-tables.td-left-hide>{{ $closingStore->date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-right-hide>@currency($closingStore->cash_from_yesterday)</x-tables.td-right-hide>
                        <x-tables.td-right-hide>@currency($closingStore->cash_for_tomorrow)</x-tables.td-right-hide>
                        <x-tables.td-right-hide>@currency($closingStore->total_cash_transfer)</x-tables.td-right-hide>
                        <x-tables.td-left-hide>{{ optional($closingStore->transfer_by)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @if ($closingStore->closing_status == 1)
                                <x-spans.yellow>belum diperiksa</x-spans.yellow>
                            @elseif ($closingStore->closing_status == 2)
                                <x-spans.green>valid</x-spans.green>
                            @elseif ($closingStore->closing_status == 3)
                                <x-spans.red>perbaiki</x-spans.red>
                            @elseif ($closingStore->closing_status == 4)
                                <x-spans.gray>periksa ulang</x-spans.gray>
                            @endif
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @if ($closingStore->transfer_status == 1)
                                <x-spans.yellow>belum diperiksa</x-spans.yellow>
                            @elseif ($closingStore->transfer_status == 2)
                                <x-spans.green>valid</x-spans.green>
                            @elseif ($closingStore->transfer_status == 3)
                                <x-spans.red>perbaiki</x-spans.red>
                            @endif
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($closingStore->created_by)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($closingStore->approved_by)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($closingStore->closing_status != '2' || $closingStore->transfer_status != '2')
                                    <a href="{{ route('closing-stores.edit', $closingStore) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @endif
                                <a href="{{ route('closing-stores.show', $closingStore) }}" class="mr-1">
                                    <x-buttons.show></x-buttons.show>
                                </a>

                                @role('super-admin')
                                    @can('delete', $closingStore)
                                        <form action="{{ route('closing-stores.destroy', $closingStore) }}" method="POST"
                                            onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                            @csrf @method('DELETE')
                                            <x-buttons.delete></x-buttons.delete>
                                        </form>
                                    @endcan
                                @endrole
                            </div>
                        </td>
                    </tr>
                @empty
                    <x-tables.no-items-found colspan="11">
                    </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="px-4 mt-10">{!! $closingStores->render() !!}</div> --}}

    <livewire:closing-stores.closing-stores-list />
</x-admin-layout>
