<x-admin-layout>
    {{-- <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.sales_order_onlines.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">---</p>
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
                @role('super-admin|manager')
                    @can('create', App\Models\SalesOrderOnline::class)
                        <a href="{{ route('sales-order-onlines.create') }}">
                            <x-jet-button>
                                <i class="mr-1 icon ion-md-add"></i>
                                @lang('crud.common.create') Sales
                            </x-jet-button>
                        </a>
                    @endcan
                @endrole
                @can('create', App\Models\Customer::class)
                    <a href="{{ route('customers.create') }}">
                        <x-jet-button>
                            <i class="mr-1 icon ion-md-add"></i>
                            @lang('crud.common.create') Customer
                        </x-jet-button>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <x-tables.th-left>@lang('crud.sales_order_onlines.inputs.image')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.sales_order_onlines.inputs.store_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.sales_order_onlines.inputs.online_shop_provider_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.sales_order_onlines.inputs.delivery_service_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.sales_order_onlines.inputs.customer_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.sales_order_onlines.inputs.receipt_no')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.sales_order_onlines.inputs.date')</x-tables.th-left>
                <x-tables.th-left>Detail Products</x-tables.th-left>
                <x-tables.th-left>@lang('crud.sales_order_onlines.inputs.status')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.sales_order_onlines.inputs.created_by_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.sales_order_onlines.inputs.approved_by_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.sales_order_onlines.inputs.notes')</x-tables.th-left>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($salesOrderOnlines as $salesOrderOnline)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>
                            @if ($salesOrderOnline->image == null)
                                <x-partials.thumbnail src="" />
                            @else
                                <a href="{{ \Storage::url($salesOrderOnline->image) }}">
                                    <x-partials.thumbnail
                                        src="{{ $salesOrderOnline->image ? \Storage::url($salesOrderOnline->image) : '' }}" />
                                </a>
                            @endif
                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>{{ optional($salesOrderOnline->store)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{ optional($salesOrderOnline->onlineShopProvider)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{ optional($salesOrderOnline->deliveryService)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($salesOrderOnline->customer)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $salesOrderOnline->receipt_no ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $salesOrderOnline->date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @foreach ($salesOrderOnline->products as $product)
                                <p> {{ $product->name }} - {{ $product->pivot->quantity }} {{ $product->unit->unit }}
                                    - @currency($product->pivot->price)</p>
                            @endforeach
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $salesOrderOnline->status_badge }}">
                                {{ $salesOrderOnline->status_name }}</x-spans.status-valid>
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($salesOrderOnline->created_by)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{ optional($salesOrderOnline->approved_by)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $salesOrderOnline->notes ?? '-' }}</x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($salesOrderOnline->status != '2')
                                    <a href="{{ route('sales-order-onlines.edit', $salesOrderOnline) }}"
                                        class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($salesOrderOnline->status == '2')
                                    <a href="{{ route('sales-order-onlines.show', $salesOrderOnline) }}"
                                        class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $salesOrderOnline)
                                <form action="{{ route('sales-order-onlines.destroy', $salesOrderOnline) }}"
                                    method="POST" onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                    @csrf @method('DELETE')
                                    <x-buttons.delete></x-buttons.delete>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <x-tables.no-items-found colspan="12">
                </x-tables.no-items-found>
            @endforelse
        </x-slot>
        <x-slot name="foot"> </x-slot>
    </x-table>
</x-tables.card>
<div class="px-4 mt-10">{!! $salesOrderOnlines->render() !!}</div> --}}

    <livewire:sales-order-onlines.sales-order-onlines-list />
</x-admin-layout>
