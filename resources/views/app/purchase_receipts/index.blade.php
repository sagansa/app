<x-admin-layout>
    {{-- <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.purchase_receipts.index_title')
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
                @can('create', App\Models\PurchaseReceipt::class)
                    <a href="{{ route('purchase-receipts.create') }}">
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
                <x-tables.th-left>@lang('crud.purchase_receipts.inputs.image')</x-tables.th-left>
                <x-tables.th-left>Detail Purchase Order</x-tables.th-left>
                <x-tables.th-left>@lang('crud.purchase_receipts.inputs.nominal_transfer')</x-tables.th-left>
                <x-tables.th-left>Total Purchase Order</x-tables.th-left>
                <x-tables.th-left>Difference</x-tables.th-left>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($purchaseReceipts as $purchaseReceipt)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>
                            @if ($purchaseReceipt->image == null)
                                <x-partials.thumbnail src="" />
                            @else
                                <a href="{{ \Storage::url($purchaseReceipt->image) }}">
                                    <x-partials.thumbnail
                                        src="{{ $purchaseReceipt->image ? \Storage::url($purchaseReceipt->image) : '' }}" />
                                </a>
                            @endif
                        </x-tables.td-left-hide>
                        <x-tables.td-right-hide>
                            @foreach ($purchaseReceipt->purchaseOrders as $purchaseOrder)
                                {{ $purchaseOrder->purchase_order_name }}
                            @endforeach
                        </x-tables.td-right-hide>
                        <x-tables.td-right-hide>@currency($purchaseReceipt->nominal_transfer)
                        </x-tables.td-right-hide>

                        <x-tables.td-right-hide>

                        </x-tables.td-right-hide>
                        <x-tables.td-right-hide>

                        </x-tables.td-right-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($purchaseReceipt->status != '2')
                                    <a href="{{ route('purchase-receipts.edit', $purchaseReceipt) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($purchaseReceipt->status == '2')
                                    <a href="{{ route('purchase-receipts.show', $purchaseReceipt) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif
                                @can('delete', $purchaseReceipt)
                                    <form action="{{ route('purchase-receipts.destroy', $purchaseReceipt) }}" method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
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
    <div class="px-4 mt-10">{!! $purchaseReceipts->render() !!}</div> --}}

    <livewire:purchase-receipts.purchase-receipts-list />
</x-admin-layout>
