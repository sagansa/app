<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.closing_couriers.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">Transfer uang tunai ke pemilik</p>
    </x-slot>

    <div class="mt-4 mb-5">
        <div class="flex flex-wrap justify-between mt-1">
            <div class="mt-1 md:w-2/3">
                <x-buttons.link wire:click.prevent="$toggle('showFilters')">
                    @if ($showFilters)
                        Hide
                    @endif Advanced Search...
                </x-buttons.link>
                @if ($showFilters)
                    <x-filters.group>
                        <x-filters.label>Bank</x-filters.label>
                        <x-filters.select wire:model="filters.bank_id">
                            @foreach ($banks as $label => $value)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-filters.select>
                    </x-filters.group>

                    <x-filters.group>
                        <x-filters.label>Status</x-filters.label>
                        <x-filters.select wire:model="filters.status">
                            @foreach (App\Models\ClosingCourier::STATUSES as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-filters.select>
                    </x-filters.group>


                    <x-buttons.link wire:click.prevent="resetFilters">Reset Filter
                    </x-buttons.link>
                @endif
            </div>
            <div class="mt-1 text-right md:w-1/3">
                @can('create', App\Models\ClosingCourier::class)
                    <a href="{{ route('closing-couriers.create') }}">
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
                <x-tables.th-left>@lang('crud.closing_couriers.inputs.image') - @lang('crud.closing_couriers.inputs.bank_id')</x-tables.th-left>
                <x-tables.th-left-hide>Nominal Transfer</x-tables.th-left-hide>
                <x-tables.th-left-hide>Detail</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.closing_couriers.inputs.total_cash_to_transfer')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.closing_couriers.inputs.status')</x-tables.th-left-hide>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($closingCouriers as $closingCourier)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-main>
                            <x-slot name="main">
                                <div class="flex items-center">
                                    @if ($closingCourier->image == null)
                                        <x-partials.thumbnail src="" />
                                    @else
                                        <a href="{{ \Storage::url($closingCourier->image) }}">
                                            <x-partials.thumbnail
                                                src="{{ $closingCourier->image ? \Storage::url($closingCourier->image) : '' }}" />
                                        </a>
                                    @endif
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">
                                            {{ optional($closingCourier->bank)->name ?? '-' }}</div>
                                    </div>
                                </div>
                            </x-slot>
                            <x-slot name="sub">
                                <p>{{ optional($closingCourier->bank)->name ?? '-' }}</p>
                                <p>@currency($closingCourier->total_cash_to_transfer)</p>
                                <x-spans.status-valid class="{{ $closingCourier->status_badge }}">
                                    {{ $closingCourier->status_name }}
                                </x-spans.status-valid>
                            </x-slot>

                        </x-tables.td-left-main>

                        <x-tables.td-right-hide>@currency($closingCourier->total_cash_to_transfer)
                        </x-tables.td-right-hide>
                        <x-tables.td-right-hide>
                            @forelse ($closingCourier->closingStores as $closingStore)
                                <p>{{ $closingStore->store->nickname }} - {{ $closingStore->shiftStore->name }}</p>
                                <p>{{ $closingStore->date->toFormattedDate() }}</p>
                            @empty
                                -
                            @endforelse
                        </x-tables.td-right-hide>
                        <x-tables.td-right-hide>
                            @currency($closingCourier->closingStores->sum('total_cash_transfer'))</x-tables.td-right-hide>
                        <x-tables.td-left-hide>
                            @role('staff|manager|supervisor')
                                <x-spans.status-valid class="{{ $closingCourier->status_badge }}">
                                    {{ $closingCourier->status_name }}
                                </x-spans.status-valid>
                            @endrole
                            @role('super-admin')
                                <select
                                    class="block w-full py-2 pl-3 pr-10 mt-1 text-xs border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    wire:change="changeStatus({{ $closingCourier }}, $event.target.value)">
                                    <option value="1" {{ $closingCourier->status == '1' ? 'selected' : '' }}>
                                        belum diperiksa</option>
                                    <option value="2" {{ $closingCourier->status == '2' ? 'selected' : '' }}>
                                        valid</option>
                                    <option value="3" {{ $closingCourier->status == '3' ? 'selected' : '' }}>
                                        perbaiki</option>
                                </select>
                            @endrole
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($closingCourier->status != '2')
                                    <a href="{{ route('closing-couriers.edit', $closingCourier) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($closingCourier->status == '2')
                                    <a href="{{ route('closing-couriers.show', $closingCourier) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $closingCourier)
                                <form action="{{ route('closing-couriers.destroy', $closingCourier) }}" method="POST"
                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                    @csrf @method('DELETE')
                                    <x-buttons.delete></x-buttons.delete>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <x-tables.no-items-found colspan="5"> </x-tables.no-items-found>
            @endforelse
        </x-slot>
        <x-slot name="foot"> </x-slot>
    </x-table>
</x-tables.card>
<div class="px-4 mt-10">{!! $closingCouriers->render() !!}</div>
</div>
