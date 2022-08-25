<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.purchase_receipts.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">Bukti transfer seluruh transaksi pembelian</p>
    </x-slot>

    <div class="mt-4 mb-5">
        <div class="flex flex-wrap justify-between mt-1">
            <div class="mt-1 md:w-1/3">
                {{-- <form>
                    <div class="flex items-center w-full">
                        <x-inputs.text name="search" value="{{ $search ?? '' }}"
                            placeholder="{{ __('crud.common.search') }}" autocomplete="off"></x-inputs.text>

                        <div class="ml-1">
                            <x-jet-button>
                                <i class="icon ion-md-search"></i>
                            </x-jet-button>
                        </div>
                    </div>
                </form> --}}
            </div>
            <div class="mt-1 text-right md:w-1/3">
                @role('super-admin')
                    @can('create', App\Models\PurchaseReceipt::class)
                        <a href="{{ route('purchase-receipts.create') }}">
                            <x-jet-button>
                                <i class="mr-1 icon ion-md-add"></i>
                                @lang('crud.common.create')
                            </x-jet-button>
                        </a>
                    @endcan
                @endrole
            </div>
        </div>
    </div>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <x-tables.th-left-hide>@lang('crud.purchase_receipts.inputs.image')</x-tables.th-left-hide>
                <x-tables.th-left>Store</x-tables.th-left>
                <x-tables.th-left-hide>Supplier</x-tables.th-left-hide>
                <x-tables.th-left-hide>Date</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.purchase_receipts.inputs.nominal_transfer')</x-tables.th-left-hide>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($purchaseReceipts as $purchaseReceipt)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-main>
                            <x-slot name="main">
                                @if ($purchaseReceipt->image == null)
                                    <x-partials.thumbnail src="" />
                                @else
                                    <a href="{{ \Storage::url($purchaseReceipt->image) }}">
                                        <x-partials.thumbnail
                                            src="{{ $purchaseReceipt->image ? \Storage::url($purchaseReceipt->image) : '' }}" />
                                    </a>
                                @endif
                            </x-slot>
                            <x-slot name="sub">
                                <p>@currency($purchaseReceipt->nominal_transfer)</p>
                                <p>
                                    @foreach ($purchaseReceipt->purchaseOrders as $purchaseOrder)
                                        {{ $purchaseOrder->store->nickname }} - {{ $purchaseOrder->supplier->name }} -
                                        {{ $purchaseOrder->date->toFormattedDate() }}
                                    @endforeach
                                </p>
                            </x-slot>
                        </x-tables.td-left-main>

                        <x-tables.td-left-hide>
                            @foreach ($purchaseReceipt->purchaseOrders as $purchaseOrder)
                                <p>{{ $purchaseOrder->store->nickname }}</p>
                            @endforeach
                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>
                            @foreach ($purchaseReceipt->purchaseOrders as $purchaseOrder)
                                <p>{{ $purchaseOrder->supplier->name }}</p>
                            @endforeach
                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>
                            @foreach ($purchaseReceipt->purchaseOrders as $purchaseOrder)
                                <p>{{ $purchaseOrder->date->toFormattedDate() }}</p>
                            @endforeach
                        </x-tables.td-left-hide>

                        <x-tables.td-right-hide>@currency($purchaseReceipt->nominal_transfer)
                        </x-tables.td-right-hide>

                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @role('super-admin')
                                    @can('update', $purchaseReceipt)
                                        <a href="{{ route('purchase-receipts.edit', $purchaseReceipt) }}" class="mr-1">
                                            <x-buttons.edit></x-buttons.edit>
                                        </a>
                                    @endcan
                                @endrole

                                @role('staff|manager|supervisor')
                                    <a href="{{ route('purchase-receipts.show', $purchaseReceipt) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endrole

                                @can('delete', $purchaseReceipt)
                                    <form action="{{ route('purchase-receipts.destroy', $purchaseReceipt) }}"
                                        method="POST" onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                        @csrf @method('DELETE')
                                        <x-buttons.delete></x-buttons.delete>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <x-tables.no-items-found colspan="3"> </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot">

            </x-slot>
        </x-table>
    </x-tables.card>
    <div class="px-4 mt-10">{!! $purchaseReceipts->render() !!}</div>
    {{-- <div class="px-4 mt-10">{{ $purchaseReceipts->links() }}</div> --}}
</div>
