<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.receipt_loyverses.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a
                        href="{{ route('receipt-loyverses.index') }}"
                        class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_loyverses.inputs.date')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptLoyverse->date ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_loyverses.inputs.receipt_number')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptLoyverse->receipt_number ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_loyverses.inputs.receipt_type')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptLoyverse->receipt_type ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_loyverses.inputs.gross_sales')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptLoyverse->gross_sales ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_loyverses.inputs.discounts')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptLoyverse->discounts ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_loyverses.inputs.net_sales')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptLoyverse->net_sales ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_loyverses.inputs.taxes')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptLoyverse->taxes ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_loyverses.inputs.total_collected')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptLoyverse->total_collected ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_loyverses.inputs.cost_of_goods')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptLoyverse->cost_of_goods ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_loyverses.inputs.gross_profit')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptLoyverse->gross_profit ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_loyverses.inputs.payment_type')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptLoyverse->payment_type ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_loyverses.inputs.description')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptLoyverse->description ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_loyverses.inputs.dining_option')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptLoyverse->dining_option ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_loyverses.inputs.pos')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptLoyverse->pos ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_loyverses.inputs.store')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptLoyverse->store ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_loyverses.inputs.cashier_name')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptLoyverse->cashier_name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_loyverses.inputs.customer_name')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptLoyverse->customer_name ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_loyverses.inputs.customer_contacts')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptLoyverse->customer_contacts ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.receipt_loyverses.inputs.status')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $receiptLoyverse->status ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $receiptLoyverse->created_at ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $receiptLoyverse->updated_at ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a
                        href="{{ route('receipt-loyverses.index') }}"
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
