<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.out_in_products.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('out-in-products.index') }}" class="mr-4"><i
                            class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.out_in_products.inputs.image')</x-shows.dt>
                        @if ($outInProduct->image != null)
                            <x-partials.thumbnail src="" size="150" />
                        @else
                            <a href="{{ \Storage::url($outInProduct->image) }}">
                                <x-partials.thumbnail
                                    src="{{ $outInProduct->image ? \Storage::url($outInProduct->image) : '' }}"
                                    size="150" />
                            </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.out_in_products.inputs.stock_card_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($outInProduct->stockCard)->date->toFormattedDate() ?? '-' }} -
                            {{ $outInProduct->stockCard->store->nickname }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.out_in_products.inputs.out_in')</x-shows.dt>
                        <x-shows.dd>
                            @if ($outInProduct->out_in == 1)
                                <x-spans.red>keluar</x-spans.red>
                            @else
                                <x-spans.green>masuk</x-spans.green>
                            @endif
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.out_in_products.inputs.to_from')</x-shows.dt>
                        <x-shows.dd>{{ $outInProduct->to_from ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.out_in_products.inputs.status')</x-shows.dt>
                        <x-shows.dd>
                            <x-spans.status-valid class="{{ $outInProduct->status_badge }}">
                                {{ $outInProduct->status_name }}
                            </x-spans.status-valid>
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl-notes>
                        <x-shows.dt>@lang('crud.out_in_products.inputs.notes')</x-shows.dt>
                        <x-shows.dd>{{ $outInProduct->notes ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl-notes>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.out_in_products.inputs.created_by_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($outInProduct->created_by)->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.out_in_products.inputs.approved_by_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($outInProduct->approved_by)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd>{{ $outInProduct->created_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd>{{ $outInProduct->updated_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('out-in-products.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @can('view-any', App\Models\OutInProduct::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title"> Products </x-slot>

                    <livewire:out-in-product-products-detail :outInProduct="$outInProduct" />
                </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
