<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.purchase_orders.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('purchase-orders.index') }}" class="mr-4"><i
                            class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    {{-- <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.purchase_orders.inputs.image')</x-shows.dt>
                        @if ($purchaseOrder->image == null)
                            <x-partials.thumbnail src="" size="150" />
                        @else
                            <a href="{{ \Storage::url($purchaseOrder->image) }}">
                                <x-partials.thumbnail
                                    src="{{ $purchaseOrder->image ? \Storage::url($purchaseOrder->image) : '' }}"
                                    size="150" />
                            </a>
                        @endif
                    </x-shows.sub-dl> --}}
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.purchase_orders.inputs.store_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($purchaseOrder->store)->nickname ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.purchase_orders.inputs.supplier_id')</x-shows.dt>
                        <x-shows.dd>
                            @if ($purchaseOrder->payment_type_id == 1)
                                <p class="text-right sm:text-left">
                                    {{ optional($purchaseOrder->supplier)->bank_account_name ?? '-' }}
                                </p>
                                <p class="text-right sm:text-left">{{ optional($purchaseOrder->supplier)->name ?? '-' }}
                                </p>
                                <p class="text-right sm:text-left">
                                    {{ optional($purchaseOrder->supplier)->bank->name ?? '-' }}</p>
                                <p class="text-right sm:text-left">
                                    {{ optional($purchaseOrder->supplier)->bank_account_no ?? '-' }}
                                </p>
                            @elseif ($purchaseOrder->payment_type_id == 2)
                                {{ optional($purchaseOrder->supplier)->name ?? '-' }}
                            @endif
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.purchase_orders.inputs.payment_type_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($purchaseOrder->paymentType)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.purchase_orders.inputs.date')</x-shows.dt>
                        <x-shows.dd>{{ $purchaseOrder->date->toFormattedDate() ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    {{-- <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.purchase_orders.inputs.taxes')</x-shows.dt>
                        <x-shows.dd>@currency($purchaseOrder->taxes)</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.purchase_orders.inputs.discounts')</x-shows.dt>
                        <x-shows.dd>@currency($purchaseOrder->discounts)</x-shows.dd>
                    </x-shows.sub-dl> --}}
                    <x-shows.sub-dl-notes>
                        <x-shows.dt>@lang('crud.purchase_orders.inputs.notes')</x-shows.dt>
                        <x-shows.dd>{{ $purchaseOrder->notes ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl-notes>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.purchase_orders.inputs.payment_status')</x-shows.dt>
                        <x-shows.dd>
                            @if ($purchaseOrder->payment_status == '1')
                                <x-spans.yellow>belum dibayar</x-spans.yellow>
                            @else
                                <x-spans.green>sudah dibayar</x-spans.green>
                            @endif
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.purchase_orders.inputs.order_status')</x-shows.dt>
                        <x-shows.dd>
                            @if ($purchaseOrder->order_status == '1')
                                <x-spans.yellow>belum diterima</x-spans.yellow>
                            @elseif ($purchaseOrder->order_status == '2')
                                <x-spans.green>sudah diterima</x-spans.green>
                            @else
                                <x-spans.red>dikembalikan</x-spans.red>
                            @endif
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.purchase_orders.inputs.created_by_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($purchaseOrder->created_by)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.purchase_orders.inputs.approved_by_id')</x-shows.dt>
                        <x-shows.dd>
                            {{ optional($purchaseOrder->approved_by)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd>{{ $purchaseOrder->created_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd>{{ $purchaseOrder->updated_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('purchase-orders.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                    @if ($purchaseOrder->payment_status != '2' || $purchaseOrder->order_status != '2')
                        <a href="{{ route('purchase-orders.edit', $purchaseOrder) }}" class="mr-1">
                            <x-jet-button>
                                <i class="mr-1 icon ion-md-create"></i>@lang('crud.common.edit')
                            </x-jet-button>
                        </a>
                    @endif
                </div>
            </x-partials.card>

            @can('view-any', App\Models\PurchaseOrder::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title"> Purchase Order Products </x-slot>

                    <livewire:purchase-order-products-detail :purchaseOrder="$purchaseOrder" />
                </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
