<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.closing_stores.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">dilaksanakan setiap hari setelah tutup shift</p>
    </x-slot>

    <x-tables.topbar>
        <x-slot name="search">
            <x-buttons.link wire:click="$toggle('showFilters')">
                @if ($showFilters)
                    Hide
                @endif Advanced Search...
            </x-buttons.link>
            @if ($showFilters)
                <x-filters.group>
                    <x-filters.label>Store</x-filters.label>
                    <x-filters.select wire:model="filters.store_id">
                        @foreach ($stores as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>
                <x-filters.group>
                    <x-filters.label>Shift Store</x-filters.label>
                    <x-filters.select wire:model="filters.shift_store_id">
                        @foreach ($shiftStores as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>
                <x-filters.group>
                    <x-filters.label>Closing Status</x-filters.label>
                    <x-filters.select wire:model="filters.status">
                        @foreach (App\Models\ClosingStore::STATUSES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>
                {{-- <x-filters.group>
                    <x-filters.label>Transfer Status</x-filters.label>
                    <x-filters.select wire:model="filters.order_status">
                        @foreach (App\Models\ClosingStore::TRANSFER_STATUSES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group> --}}

                <x-buttons.link wire:click="resetFilters">Reset Filter
                </x-buttons.link>
            @endif

        </x-slot>
        <x-slot name="action">
            <div class="flex flex-wrap justify-between mt-1">
                <div class="mt-1 md:w-1/3">
                    @role('super-admin')
                        <x-buttons.green wire:click="markAllAsValid">Valid</x-buttons.green>
                        <x-buttons.yellow wire:click="markAllAsBelumDiperiksa">Belum Diperiksa</x-buttons.yellow>
                        <x-buttons.red wire:click='markAllAsPerbaiki'>Perbaiki</x-buttons.red>
                        <x-buttons.gray wire:click="markAllAsPeriksaUlang">Periksa Ulang</x-buttons.gray>
                    @endrole
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
        </x-slot>
    </x-tables.topbar>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                @role('super-admin')
                    <th></th>
                @endrole
                <x-tables.th-left>@lang('crud.closing_stores.inputs.store_id')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.closing_stores.inputs.date')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.closing_stores.inputs.cash_from_yesterday')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.closing_stores.inputs.cash_for_tomorrow')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.closing_stores.inputs.total_cash_transfer')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.closing_stores.inputs.transfer_by_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>Closing Status</x-tables.th-left-hide>
                <x-tables.th-left-hide>Transfer Status</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.closing_stores.inputs.created_by_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.closing_stores.inputs.approved_by_id')</x-tables.th-left-hide>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($closingStores as $closingStore)
                    <tr class="hover:bg-gray-50">
                        @role('super-admin|manager')
                            <x-tables.td-checkbox id="{{ $closingStore->id }}"></x-tables.td-checkbox>
                        @endrole
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
                            @if ($closingStore->status == 1)
                                <x-spans.yellow>belum diperiksa</x-spans.yellow>
                            @elseif ($closingStore->status == 2)
                                <x-spans.green>valid</x-spans.green>
                            @elseif ($closingStore->status == 3)
                                <x-spans.red>perbaiki</x-spans.red>
                            @elseif ($closingStore->status == 4)
                                <x-spans.gray>periksa ulang</x-spans.gray>
                            @endif
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @foreach ($closingStore->closingCouriers as $closingCourier)
                                @if ($closingCourier->status == 1)
                                    <x-spans.yellow>belum diperiksa</x-spans.yellow>
                                @elseif ($closingCourier->status == 2)
                                    <x-spans.green>valid</x-spans.green>
                                @elseif ($closingCourier->status == 3)
                                    <x-spans.red>perbaiki</x-spans.red>
                                @elseif ($closingCourier->status == 4)
                                    <x-spans.gray>periksa ulang</x-spans.gray>
                                @endif
                            @endforeach

                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($closingStore->created_by)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($closingStore->approved_by)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($closingStore->status != '2')
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
    <div class="px-4 mt-10">{!! $closingStores->render() !!}</div>
</div>
