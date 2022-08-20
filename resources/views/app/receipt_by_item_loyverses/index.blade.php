<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.receipt_by_item_loyverses.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">---</p>
    </x-slot>

    <div class="mb-5 mt-4">
        <div class="flex flex-wrap justify-between mt-1">
            <div class="mt-1 md:w-1/3">
                <form>
                    <div class="flex items-center w-full">
                        <x-inputs.text
                            name="search"
                            value="{{ $search ?? '' }}"
                            placeholder="{{ __('crud.common.search') }}"
                            autocomplete="off"
                        ></x-inputs.text>

                        <div class="ml-1">
                            <x-jet-button>
                                <i class="icon ion-md-search"></i>
                            </x-jet-button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="mt-1 md:w-1/3 text-right">
                @can('create', App\Models\ReceiptByItemLoyverse::class)
                <a href="{{ route('receipt-by-item-loyverses.create') }}"
                    ><x-jet-button>
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')</x-jet-button
                    >
                </a>
                @endcan
            </div>
        </div>
    </div>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.date')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.receipt_number')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.receipt_type')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.category')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.sku')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.item')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.variant')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.modifiers_applied')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.quantity')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.gross_sales')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.discounts')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.net_sales')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.cost_of_goods')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.gross_profit')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.taxes')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.dining_option')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.pos')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.store')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.cashier_name')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.customer_name')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.customer_contacts')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.comment')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_by_item_loyverses.inputs.status')</x-tables.th-left
                >
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($receiptByItemLoyverses as $receiptByItemLoyverse)
                <tr class="hover:bg-gray-50">
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->date ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->receipt_number ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->receipt_type ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->category ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->sku ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->item ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->variant ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->modifiers_applied ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-right-hide
                        >{{ $receiptByItemLoyverse->quantity ?? '-'
                        }}</x-tables.td-right-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->gross_sales ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->discounts ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->net_sales ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->cost_of_goods ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->gross_profit ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->taxes ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->dining_option ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->pos ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->store ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->cashier_name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->customer_name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->customer_contacts ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->comment ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptByItemLoyverse->status ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <td class="px-4 py-3 text-center" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @if($receiptByItemLoyverse->status != '2')
                            <a
                                href="{{ route('receipt-by-item-loyverses.edit', $receiptByItemLoyverse) }}"
                                class="mr-1"
                            >
                                <x-buttons.edit></x-buttons.edit>
                            </a>
                            @elseif($receiptByItemLoyverse->status == '2')
                            <a
                                href="{{ route('receipt-by-item-loyverses.show', $receiptByItemLoyverse) }}"
                                class="mr-1"
                            >
                                <x-buttons.show></x-buttons.show>
                            </a>
                            @endif @can('delete', $receiptByItemLoyverse)
                            <form
                                action="{{ route('receipt-by-item-loyverses.destroy', $receiptByItemLoyverse) }}"
                                method="POST"
                                onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                            >
                                @csrf @method('DELETE')
                                <x-buttons.delete></x-buttons.delete>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <x-tables.no-items-found colspan="24">
                </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="mt-10 px-4">{!! $receiptByItemLoyverses->render() !!}</div>
</x-admin-layout>
