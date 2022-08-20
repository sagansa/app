<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.remaining_stocks.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('remaining-stocks.index') }}" class="mr-4"><i
                            class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.remaining_stocks.inputs.store_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($remainingStock->store)->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.remaining_stocks.inputs.date')</x-shows.dt>
                        <x-shows.dd>{{ $remainingStock->date->toFormattedDate() ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Remaining</x-shows.dt>
                        <x-shows.dd>
                            @foreach ($remainingStock->products as $product)
                                <table>
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>=
                                            @if ($product->pivot->quantity == null)
                                                <x-spans.text-red>0</x-spans.text-red>
                                            @else
                                                <x-spans.text-black>{{ $product->pivot->quantity }}
                                                </x-spans.text-black>
                                            @endif
                                            {{ $product->unit->unit }}
                                        </td>
                                    </tr>
                                </table>
                            @endforeach
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.remaining_stocks.inputs.status')</x-shows.dt>
                        <x-shows.dd>
                            <x-spans.status-valid class="{{ $remainingStock->status_badge }}">
                                {{ $remainingStock->status_name }}
                            </x-spans.status-valid>
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl-notes>
                        <x-shows.dt>@lang('crud.remaining_stocks.inputs.notes')</x-shows.dt>
                        <x-shows.dd>{{ $remainingStock->notes ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl-notes>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.remaining_stocks.inputs.created_by_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($remainingStock->created_by)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.remaining_stocks.inputs.approved_by_id')</x-shows.dt>
                        <x-shows.dd>
                            {{ optional($remainingStock->approved_by)->name ?? '-' }}
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd>{{ $remainingStock->created_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd>{{ $remainingStock->updated_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('remaining-stocks.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @can('view-any', App\Models\product_remaining_stock::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title"> Products </x-slot>

                    <livewire:remaining-stock-products-detail :remainingStock="$remainingStock" />
                </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
