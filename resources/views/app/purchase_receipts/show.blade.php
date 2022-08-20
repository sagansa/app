<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.purchase_receipts.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('purchase-receipts.index') }}" class="mr-4"><i
                            class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.purchase_receipts.inputs.image')</x-shows.dt>
                        @if ($purchaseReceipt->image != null)
                            <x-partials.thumbnail src="" size="150" />
                        @else
                            <a href="{{ \Storage::url($purchaseReceipt->image) }}">
                                <x-partials.thumbnail
                                    src="{{ $purchaseReceipt->image ? \Storage::url($purchaseReceipt->image) : '' }}"
                                    size="150" />
                            </a>
                        @endif
                    </x-shows.sub-dl>
                    {{-- <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.purchase_receipts.inputs.nominal_transfer')</x-shows.dt>
                        <x-shows.dd>@currency($purchaseReceipt->nominal_transfer)</x-shows.dd>
                    </x-shows.sub-dl> --}}
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd>{{ $purchaseReceipt->created_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd>{{ $purchaseReceipt->updated_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('purchase-receipts.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                    @role('super-admin')
                        <a href="{{ route('purchase-receipts.edit', $purchaseReceipt) }}" class="mr-1">
                            <x-jet-button>
                                <i class="mr-1 icon ion-md-create"></i>@lang('crud.common.edit')
                            </x-jet-button>
                        </a>
                    @endrole

                </div>
            </x-partials.card>

            @can('view-any', App\Models\PurchaseReceipt::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title"> Purchase Orders </x-slot>

                    <livewire:purchase-receipt-purchase-orders-detail :purchaseReceipt="$purchaseReceipt" />
                </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
