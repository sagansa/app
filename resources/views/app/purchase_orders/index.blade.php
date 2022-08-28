<x-admin-layout>
    {{-- @role('staff|supervisor')
        <x-slot name="header">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                @lang('crud.purchase_orders.index_title')
            </h2>
            <p class="mt-2 text-xs text-gray-700">seluruh pembelian yang dilakukan masing-masing warung, wajib harus ada
                kuitansi yang valid, serta untuk bahan baku utama dilanjutkan dengan membuat production</p>
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
                    @can('create', App\Models\PurchaseOrder::class)
                        <a href="{{ route('purchase-orders.create') }}">
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
                    <x-tables.th-left>@lang('crud.purchase_orders.inputs.image')</x-tables.th-left>
                    <x-tables.th-left-hide>@lang('crud.purchase_orders.inputs.store_id')</x-tables.th-left-hide>
                    <x-tables.th-left-hide>@lang('crud.purchase_orders.inputs.supplier_id')</x-tables.th-left-hide>
                    <x-tables.th-left-hide>Account Number</x-tables.th-left-hide>
                    <x-tables.th-left-hide>@lang('crud.purchase_orders.inputs.payment_type_id')</x-tables.th-left-hide>
                    <x-tables.th-left-hide>@lang('crud.purchase_orders.inputs.date')</x-tables.th-left-hide>

                    <x-tables.th-left-hide>Detail Order</x-tables.th-left-hide>
                    <x-tables.th-left-hide>@lang('crud.purchase_orders.inputs.payment_status')</x-tables.th-left-hide>
                    <x-tables.th-left-hide>@lang('crud.purchase_orders.inputs.order_status')</x-tables.th-left-hide>
                    @role('super-admin|supervisor|manager')
                        <x-tables.th-left-hide>@lang('crud.purchase_orders.inputs.created_by_id')</x-tables.th-left-hide>
                    @endrole
                    @role('super-admin|staff|manager')
                        <x-tables.th-left-hide>@lang('crud.purchase_orders.inputs.approved_by_id')</x-tables.th-left-hide>
                    @endrole
                    <th></th>
                </x-slot>
                <x-slot name="body">
                    @forelse($purchaseOrders as $purchaseOrder)
                        <tr class="hover:bg-gray-50">
                            <x-tables.td-left-main>
                                <x-slot name="main">
                                    @if ($purchaseOrder->image == null)
                                        <x-partials.thumbnail src="" />
                                    @else
                                        <a href="{{ \Storage::url($purchaseOrder->image) }}">
                                            <x-partials.thumbnail
                                                src="{{ $purchaseOrder->image ? \Storage::url($purchaseOrder->image) : '' }}" />
                                        </a>
                                    @endif

                                </x-slot>
                                <x-slot name="sub">
                                    <p>{{ optional($purchaseOrder->store)->nickname ?? '-' }}</p>
                                    <p>{{ optional($purchaseOrder->supplier)->name ?? '-' }}</p>
                                    <p>
                                        @if ($purchaseOrder->payment_type_id == '1')
                                            {{ optional($purchaseOrder->supplier)->bank->name ?? '-' }} -
                                            {{ optional($purchaseOrder->supplier)->bank_account_no ?? '-' }} -
                                            {{ optional($purchaseOrder->supplier)->bank_account_name ?? '-' }}
                                        @endif
                                    </p>
                                    <p>{{ optional($purchaseOrder->paymentType)->name ?? '-' }}</p>
                                    <p>{{ $purchaseOrder->date->toFormattedDate() ?? '-' }}</p>
                                    <p>
                                        @if ($purchaseOrder->payment_status == '1')
                                            <x-spans.yellow>belum dibayar</x-spans.yellow>
                                        @else
                                            <x-spans.green>sudah dibayar</x-spans.green>
                                        @endif
                                        @if ($purchaseOrder->order_status == '1')
                                            <x-spans.yellow>belum diterima</x-spans.yellow>
                                        @elseif ($purchaseOrder->order_status == '2')
                                            <x-spans.green>sudah diterima</x-spans.green>
                                        @else
                                            <x-spans.red>dikembalikan</x-spans.red>
                                        @endif
                                    </p>
                                </x-slot>
                            </x-tables.td-left-main>

                            <x-tables.td-left-hide>{{ optional($purchaseOrder->store)->nickname ?? '-' }}
                            </x-tables.td-left-hide>
                            <x-tables.td-left-hide>{{ optional($purchaseOrder->supplier)->name ?? '-' }}
                            </x-tables.td-left-hide>
                            <x-tables.td-left-hide>
                                @if ($purchaseOrder->payment_type_id == '1')
                                    {{ optional($purchaseOrder->supplier)->bank->name ?? '-' }} -
                                    {{ optional($purchaseOrder->supplier)->bank_account_no ?? '-' }} -
                                    {{ optional($purchaseOrder->supplier)->bank_account_name ?? '-' }}
                                @endif
                            </x-tables.td-left-hide>
                            <x-tables.td-left-hide>{{ optional($purchaseOrder->paymentType)->name ?? '-' }}
                            </x-tables.td-left-hide>
                            <x-tables.td-left-hide>{{ $purchaseOrder->date->toFormattedDate() ?? '-' }}
                            </x-tables.td-left-hide>

                            <x-tables.td-left-hide>
                                @foreach ($purchaseOrder->purchaseOrderProducts as $purchaseOrderProduct)
                                    <p>{{ $purchaseOrderProduct->product->name }} =
                                        {{ $purchaseOrderProduct->quantity_invoice }}
                                        {{ $purchaseOrderProduct->unit->unit }}</p>
                                    <p>@currency($purchaseOrderProduct->subtotal_invoice)</p>
                                @endforeach
                            </x-tables.td-left-hide>
                            <x-tables.td-left-hide>
                                @if ($purchaseOrder->payment_status == '1')
                                    <x-spans.yellow>belum dibayar</x-spans.yellow>
                                @else
                                    <x-spans.green>sudah dibayar</x-spans.green>
                                @endif
                            </x-tables.td-left-hide>
                            <x-tables.td-left-hide>
                                @if ($purchaseOrder->order_status == '1')
                                    <x-spans.yellow>belum diterima</x-spans.yellow>
                                @elseif ($purchaseOrder->order_status == '2')
                                    <x-spans.green>sudah diterima</x-spans.green>
                                @else
                                    <x-spans.red>dikembalikan</x-spans.red>
                                @endif
                            </x-tables.td-left-hide>
                            @role('super-admin|supervisor|manager')
                                <x-tables.td-left-hide>{{ optional($purchaseOrder->created_by)->name ?? '-' }}
                                </x-tables.td-left-hide>
                            @endrole
                            @role('super-admin|staff|manager')
                                <x-tables.td-left-hide>{{ optional($purchaseOrder->approved_by)->name ?? '-' }}
                                </x-tables.td-left-hide>
                            @endrole
                            <td class="px-4 py-3 text-center" style="width: 134px;">
                                <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                    @if ($purchaseOrder->payment_status != '2' || $purchaseOrder->order_status != '2')
                                        <a href="{{ route('purchase-orders.edit', $purchaseOrder) }}" class="mr-1">
                                            <x-buttons.edit></x-buttons.edit>
                                        </a>
                                    @elseif($purchaseOrder->status == '2')
                                        <a href="{{ route('purchase-orders.show', $purchaseOrder) }}" class="mr-1">
                                            <x-buttons.show></x-buttons.show>
                                        </a>
                                    @endif
                                    @can('delete', $purchaseOrder)
                                        <form action="{{ route('purchase-orders.destroy', $purchaseOrder) }}" method="POST"
                                            onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                            @csrf @method('DELETE')
                                            <x-buttons.delete></x-buttons.delete>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-tables.no-items-found colspan="10">
                        </x-tables.no-items-found>
                    @endforelse
                </x-slot>
                <x-slot name="foot"> </x-slot>
            </x-table>
        </x-tables.card>
        <div class="px-4 mt-10">{!! $purchaseOrders->render() !!}</div>
    @endrole --}}

    {{-- @role('super-admin') --}}
    <livewire:purchase-orders.purchase-orders-list />
    {{-- @endrole --}}
</x-admin-layout>
