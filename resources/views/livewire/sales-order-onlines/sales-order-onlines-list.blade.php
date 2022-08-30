<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.sales_order_onlines.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">Laporan penjualan untuk order dari online shop</p>
    </x-slot>

    <x-tables.topbar>
        <x-slot name="search">
            <x-buttons.link wire:click.prevent="$toggle('showFilters')">
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
                    <x-filters.label>Customer</x-filters.label>
                    <x-filters.select wire:model="filters.customer_id">
                        @foreach ($customers as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>
                <x-filters.group>
                    <x-filters.label>Online Shop Provider</x-filters.label>
                    <x-filters.select wire:model="filters.online_shop_provider_id">
                        @foreach ($onlineShopProviders as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>
                <x-filters.group>
                    <x-filters.label>Delivery Service</x-filters.label>
                    <x-filters.select wire:model="filters.delivery_service_id">
                        @foreach ($deliveryServices as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>
                <x-filters.group>
                    <x-filters.label>Status</x-filters.label>
                    <x-filters.select wire:model="filters.status">
                        @foreach (App\Models\SalesOrderOnline::STATUSES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>

                <x-buttons.link wire:click.prevent="resetFilters">Reset Filter
                </x-buttons.link>
            @endif
        </x-slot>
        <x-slot name="action">
            <div class="flex flex-wrap justify-between mt-1">
                <div class="mt-1 md:w-1/2">
                    @role('super-admin')
                        <x-buttons.green wire:click.prevent="markAllAsBelumDikirim">Belum Dikirim</x-buttons.green>
                        <x-buttons.yellow wire:click.prevent="markAllAsValid">Valid</x-buttons.yellow>
                        <x-buttons.red wire:click.prevent="markAllAsSudahDikirim">Sudah Dikirim</x-buttons.red>
                        <x-buttons.gray wire:click.prevent="markAllAsDikembalikan">Dikembalikan</x-buttons.gray>
                    @endrole
                </div>
                <div class="mt-1 text-right md:w-1/2">
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
        </x-slot>
    </x-tables.topbar>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                @role('super-admin|manager')
                    <th></th>
                @endrole
                <x-tables.th-left-hide>@lang('crud.sales_order_onlines.inputs.image')</x-tables.th-left-hide>
                <x-tables.th-left>@lang('crud.sales_order_onlines.inputs.store_id')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.sales_order_onlines.inputs.online_shop_provider_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.sales_order_onlines.inputs.delivery_service_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.sales_order_onlines.inputs.customer_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.sales_order_onlines.inputs.receipt_no')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.sales_order_onlines.inputs.date')</x-tables.th-left-hide>
                <x-tables.th-left-hide>Detail Products</x-tables.th-left-hide>
                <x-tables.th-left-hide>Total</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.sales_order_onlines.inputs.status')</x-tables.th-left-hide>
                {{-- <x-tables.th-left>@lang('crud.sales_order_onlines.inputs.created_by_id')</x-tables.th-left> --}}
                {{-- <x-tables.th-left>@lang('crud.sales_order_onlines.inputs.approved_by_id')</x-tables.th-left> --}}
                {{-- <x-tables.th-left>@lang('crud.sales_order_onlines.inputs.notes')</x-tables.th-left> --}}
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($salesOrderOnlines as $salesOrderOnline)
                    <tr class="hover:bg-gray-50">
                        @role('super-admin|manager')
                            <x-tables.td-checkbox id="{{ $salesOrderOnline->id }}"></x-tables.td-checkbox>
                        @endrole
                        <x-tables.td-left-main>
                            <x-slot name="main">
                                <div class="relative z-0 flex -space-x-2 overflow-hidden">
                                    <div class="mr-1">
                                        @if ($salesOrderOnline->image == null)
                                            <x-partials.thumbnail src="" />
                                        @else
                                            <a href="{{ \Storage::url($salesOrderOnline->image) }}">
                                                <x-partials.thumbnail
                                                    src="{{ $salesOrderOnline->image ? \Storage::url($salesOrderOnline->image) : '' }}" />
                                            </a>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($salesOrderOnline->image_sent == null)
                                            <x-partials.thumbnail src="" />
                                        @else
                                            <a href="{{ \Storage::url($salesOrderOnline->image_sent) }}">
                                                <x-partials.thumbnail
                                                    src="{{ $salesOrderOnline->image_sent ? \Storage::url($salesOrderOnline->image_sent) : '' }}" />
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </x-slot>
                            <x-slot name="sub">{{ optional($salesOrderOnline->store)->nickname ?? '-' }} |
                                {{ optional($salesOrderOnline->onlineShopProvider)->name ?? '-' }} |
                                {{ optional($salesOrderOnline->deliveryService)->name ?? '-' }} |
                                {{ optional($salesOrderOnline->customer)->name ?? '-' }} |
                                {{ $salesOrderOnline->receipt_no ?? '-' }} |
                                {{ $salesOrderOnline->date->toFormattedDate() ?? '-' }}
                                <x-spans.status-valid class="{{ $salesOrderOnline->status_badge }}">
                                    {{ $salesOrderOnline->status_name }}</x-spans.status-valid>
                            </x-slot>
                        </x-tables.td-left-main>

                        <x-tables.td-left-hide>{{ optional($salesOrderOnline->store)->nickname ?? '-' }}
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
                            @forelse ($salesOrderOnline->products as $product)
                                <p> {{ $product->name }} - {{ $product->pivot->quantity }} {{ $product->unit->unit }}
                                    - @currency($product->pivot->price)</p>
                            @empty
                                -
                            @endforelse
                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>
                            @currency($salesOrderOnline->pivot->products->sum('price'))
                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>

                            <x-spans.status-valid class="{{ $salesOrderOnline->status_badge }}">
                                {{ $salesOrderOnline->status_name }}</x-spans.status-valid>
                        </x-tables.td-left-hide>
                        {{-- <x-tables.td-left-hide>{{ optional($salesOrderOnline->created_by)->name ?? '-' }}
                        </x-tables.td-left-hide> --}}
                        {{-- <x-tables.td-left-hide>
                            {{ optional($salesOrderOnline->approved_by)->name ?? '-' }}
                        </x-tables.td-left-hide> --}}
                        {{-- <x-tables.td-left-hide>{{ $salesOrderOnline->notes ?? '-' }}</x-tables.td-left-hide> --}}
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
                                @endif
                                @can('delete', $salesOrderOnline)
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
    <div class="px-4 mt-10">{!! $salesOrderOnlines->render() !!}</div>
</div>
