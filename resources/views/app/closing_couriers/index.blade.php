<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.closing_couriers.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">Transfer uang tunai ke pemilik</p>
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
                <x-tables.th-left>@lang('crud.closing_couriers.inputs.image')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.closing_couriers.inputs.bank_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.closing_couriers.inputs.total_cash_to_transfer')</x-tables.th-left-hide>
                <x-tables.th-left-hide>Detail</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.closing_couriers.inputs.status')</x-tables.th-left-hide>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($closingCouriers as $closingCourier)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-main>
                            <x-slot name="main">
                                @if ($closingCourier->image == null)
                                    <x-partials.thumbnail src="" />
                                @else
                                    <a href="{{ \Storage::url($closingCourier->image) }}">
                                        <x-partials.thumbnail
                                            src="{{ $closingCourier->image ? \Storage::url($closingCourier->image) : '' }}" />
                                    </a>
                                @endif
                            </x-slot>
                            <x-slot name="sub">
                                <p>{{ optional($closingCourier->bank)->name ?? '-' }}</p>
                                <p>@currency($closingCourier->total_cash_to_transfer)</p>
                                <x-spans.status-valid class="{{ $closingCourier->status_badge }}">
                                    {{ $closingCourier->status_name }}
                                </x-spans.status-valid>
                            </x-slot>

                        </x-tables.td-left-main>

                        <x-tables.td-left-hide>{{ optional($closingCourier->bank)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-right-hide>@currency($closingCourier->total_cash_to_transfer)
                        </x-tables.td-right-hide>
                        <x-tables.td-right-hide>
                            @forelse ($closingCourier->closingStores as $closingStore)
                                <p>{{ $closingStore->date->toFormattedDate() }}</p>
                                <p>{{ $closingStore->store->nickname }}</p>
                                <p>{{ $closingStore->shiftStore->name }}</p>
                                <p>{{ $closingStore->total_cash_transfer }}</p>
                            @empty
                                -
                            @endforelse
                        </x-tables.td-right-hide>
                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $closingCourier->status_badge }}">
                                {{ $closingCourier->status_name }}
                            </x-spans.status-valid>
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
</x-admin-layout>
