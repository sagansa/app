<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.transfer_stocks.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('transfer-stocks.index') }}" class="mr-4"><i
                            class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.transfer_stocks.inputs.date')</x-shows.dt>
                        <x-shows.dd>{{ $transferStock->date->toFormattedDate() ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.transfer_stocks.inputs.from_store_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($transferStock->from_store)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.transfer_stocks.inputs.to_store_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($transferStock->to_store)->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.transfer_stocks.inputs.status')</x-shows.dt>
                        <x-shows.dd>
                            <x-spans.status-valid class="{{ $transferStock->status_badge }}">
                                {{ $transferStock->status_name }}
                            </x-spans.status-valid>
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.transfer_stocks.inputs.received_by_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($transferStock->received_by)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.transfer_stocks.inputs.sent_by_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($transferStock->sent_by)->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.transfer_stocks.inputs.approved_by_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($transferStock->approved_by)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl-notes>
                        <x-shows.dt>@lang('crud.transfer_stocks.inputs.notes')</x-shows.dt>
                        <x-shows.dd>{{ $transferStock->notes ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl-notes>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd>{{ $transferStock->created_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd>{{ $transferStock->updated_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('transfer-stocks.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @can('view-any', App\Models\product_transfer_stock::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title"> Products </x-slot>

                    <livewire:transfer-stock-products-detail :transferStock="$transferStock" />
                </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
