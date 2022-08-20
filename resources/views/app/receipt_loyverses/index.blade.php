<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.receipt_loyverses.index_title')
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
                @can('create', App\Models\ReceiptLoyverse::class)
                <a href="{{ route('receipt-loyverses.create') }}"
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
                    >@lang('crud.receipt_loyverses.inputs.date')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_loyverses.inputs.receipt_number')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_loyverses.inputs.receipt_type')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_loyverses.inputs.gross_sales')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_loyverses.inputs.discounts')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_loyverses.inputs.net_sales')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_loyverses.inputs.taxes')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_loyverses.inputs.total_collected')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_loyverses.inputs.cost_of_goods')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_loyverses.inputs.gross_profit')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_loyverses.inputs.payment_type')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_loyverses.inputs.description')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_loyverses.inputs.dining_option')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_loyverses.inputs.pos')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_loyverses.inputs.store')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_loyverses.inputs.cashier_name')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_loyverses.inputs.customer_name')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_loyverses.inputs.customer_contacts')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.receipt_loyverses.inputs.status')</x-tables.th-left
                >
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($receiptLoyverses as $receiptLoyverse)
                <tr class="hover:bg-gray-50">
                    <x-tables.td-left-hide
                        >{{ $receiptLoyverse->date ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptLoyverse->receipt_number ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptLoyverse->receipt_type ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptLoyverse->gross_sales ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptLoyverse->discounts ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptLoyverse->net_sales ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptLoyverse->taxes ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptLoyverse->total_collected ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptLoyverse->cost_of_goods ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptLoyverse->gross_profit ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptLoyverse->payment_type ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptLoyverse->description ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptLoyverse->dining_option ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptLoyverse->pos ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptLoyverse->store ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptLoyverse->cashier_name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptLoyverse->customer_name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptLoyverse->customer_contacts ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $receiptLoyverse->status ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <td class="px-4 py-3 text-center" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @if($receiptLoyverse->status != '2')
                            <a
                                href="{{ route('receipt-loyverses.edit', $receiptLoyverse) }}"
                                class="mr-1"
                            >
                                <x-buttons.edit></x-buttons.edit>
                            </a>
                            @elseif($receiptLoyverse->status == '2')
                            <a
                                href="{{ route('receipt-loyverses.show', $receiptLoyverse) }}"
                                class="mr-1"
                            >
                                <x-buttons.show></x-buttons.show>
                            </a>
                            @endif @can('delete', $receiptLoyverse)
                            <form
                                action="{{ route('receipt-loyverses.destroy', $receiptLoyverse) }}"
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
                <x-tables.no-items-found colspan="20">
                </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="mt-10 px-4">{!! $receiptLoyverses->render() !!}</div>
</x-admin-layout>
