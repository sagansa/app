<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.receipt_by_item_loyverses.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a
                        href="{{ route('receipt-by-item-loyverses.index') }}"
                        class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.date')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->date ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.receipt_number')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->receipt_number ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.receipt_type')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->receipt_type ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.category')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->category ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.sku')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->sku ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.item')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->item ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.variant')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->variant ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.modifiers_applied')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->modifiers_applied ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.quantity')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->quantity ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.gross_sales')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->gross_sales ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.discounts')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->discounts ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.net_sales')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->net_sales ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.cost_of_goods')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->cost_of_goods ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.gross_profit')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->gross_profit ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.taxes')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->taxes ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.dining_option')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->dining_option ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.pos')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->pos ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.store')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->store ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.cashier_name')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->cashier_name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.customer_name')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->customer_name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.customer_contacts')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->customer_contacts ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.comment')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->comment ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_by_item_loyverses.inputs.status')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->status ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->created_at ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $receiptByItemLoyverse->updated_at ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a
                        href="{{ route('receipt-by-item-loyverses.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-admin-layout>
