<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.closing_stores.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('closing-stores.index') }}" class="mr-4"><i
                            class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.closing_stores.inputs.store_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($closingStore->store)->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.closing_stores.inputs.shift_store_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($closingStore->shiftStore)->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.closing_stores.inputs.date')</x-shows.dt>
                        <x-shows.dd>{{ $closingStore->date->toFormattedDate() ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    {{-- <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.closing_stores.inputs.transfer_by_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($closingStore->transfer_by)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl> --}}
                    {{-- <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.closing_stores.inputs.cash_from_yesterday')</x-shows.dt>
                        <x-shows.dd>
                            @currency($closingStore->cash_from_yesterday)</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.closing_stores.inputs.cash_for_tomorrow')</x-shows.dt>
                        <x-shows.dd>
                            @currency($closingStore->cash_for_tomorrow)</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.closing_stores.inputs.total_cash_transfer')</x-shows.dt>
                        <x-shows.dd>

                            @currency($closingStore->total_cash_transfer)</x-shows.dd>
                    </x-shows.sub-dl> --}}
                    <x-shows.sub-dl-notes>
                        <x-shows.dt>@lang('crud.closing_stores.inputs.notes')</x-shows.dt>
                        <x-shows.dd>{{ $closingStore->notes ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl-notes>
                    <x-shows.sub-dl>
                        <x-shows.dt>Closing Status</x-shows.dt>
                        <x-shows.dd>
                            @if ($closingStore->status == 1)
                                <x-spans.yellow>belum diperiksa</x-spans.yellow>
                            @elseif ($closingStore->status == 2)
                                <x-spans.green>valid</x-spans.green>
                            @elseif ($closingStore->status == 3)
                                <x-spans.red>perbaiki</x-spans.red>
                            @elseif ($closingStore->status == 4)
                                <x-spans.gray>periksa ulang</x-spans.gray>
                            @endif
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Payment Status</x-shows.dt>
                        <x-shows.dd>
                            @foreach ($closingStore->closingCouriers as $closingCourier)
                                @if ($closingCourier->status == 1)
                                    <x-spans.yellow>belum diperiksa</x-spans.yellow>
                                @elseif ($closingCourier->status == 2)
                                    <x-spans.green>valid</x-spans.green>
                                @elseif ($closingCourier->status == 3)
                                    <x-spans.red>perbaiki</x-spans.red>
                                @endif
                            @endforeach

                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.closing_stores.inputs.created_by_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($closingStore->created_by)->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.closing_stores.inputs.approved_by_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($closingStore->approved_by)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd>{{ $closingStore->created_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd>{{ $closingStore->updated_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('closing-stores.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            <x-partials.card class="mt-5">
                <x-slot name="title"> Summary </x-slot>
                <livewire:closing-stores.check-closing-store :closingStore="$closingStore" />
            </x-partials.card>

            @can('view-any', App\Models\ClosingStore::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title"> Purchase Orders </x-slot>

                    <livewire:closing-store-purchase-orders-detail :closingStore="$closingStore" />
                </x-partials.card>
            @endcan

            @can('view-any', App\Models\ClosingStore::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title"> Presences </x-slot>

                    <livewire:closing-store-presences :closingStore="$closingStore" />
                </x-partials.card>
            @endcan
            @can('view-any', App\Models\ClosingStore::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title"> Fuel Services </x-slot>

                    <livewire:closing-store-fuel-services-detail :closingStore="$closingStore" />
                </x-partials.card>
            @endcan
            @can('view-any', App\Models\ClosingStore::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title"> Cashlesses </x-slot>

                    <livewire:closing-store-cashlesses-detail :closingStore="$closingStore" />
                </x-partials.card>
            @endcan

        </div>
    </div>
</x-admin-layout>
