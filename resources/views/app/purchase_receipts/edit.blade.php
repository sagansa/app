@if ($purchaseReceipt->status != 2)
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.purchase_receipts.edit_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a
                        href="{{ route('purchase-receipts.index') }}"
                        class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-form
                    method="PUT"
                    action="{{ route('purchase-receipts.update', $purchaseReceipt) }}"
                    has-files
                    class="mt-4"
                >
                    @include('app.purchase_receipts.form-inputs')

                    <div class="mt-10">
                        <a
                            href="{{ route('purchase-receipts.index') }}"
                            class="button"
                        >
                            <i
                                class="
                                    mr-1
                                    icon
                                    ion-md-return-left
                                    text-primary
                                "
                            ></i>
                            @lang('crud.common.back')
                        </a>

                        <x-jet-button class="float-right">
                            <i class="mr-1 icon ion-md-save"></i>
                            @lang('crud.common.update')
                        </x-jet-button>
                    </div>
                </x-form>
            </x-partials.card>

            @can('view-any', App\Models\PurchaseOrder::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Purchase Orders </x-slot>

                <livewire:purchase-receipt-purchase-orders-detail
                    :purchaseReceipt="$purchaseReceipt"
                />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
@else
<x-admin-layout>
    <a href="{{ route('purchase-receipts.index') }}" class="button">
        <i class="mr-1 icon ion-md-return-left text-primary"></i>
        FORBIDDEN ACCESS @lang('crud.common.back')
    </a>
</x-admin-layout>
@endif
