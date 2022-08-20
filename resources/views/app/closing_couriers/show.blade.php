<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.closing_couriers.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('closing-couriers.index') }}" class="mr-4"><i
                            class="mr-1 icon ion-md-arrow-back"></i></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.closing_couriers.inputs.image')</x-shows.dt>
                        @if ($closingCourier->image != null)
                            <x-partials.thumbnail src="" size="150" />
                        @else
                            <a href="{{ \Storage::url($closingCourier->image) }}">
                                <x-partials.thumbnail
                                    src="{{ $closingCourier->image ? \Storage::url($closingCourier->image) : '' }}"
                                    size="150" />
                            </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.closing_couriers.inputs.bank_id')</x-shows.dt>
                        <x-shows.dd>{{ optional($closingCourier->bank)->name ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.closing_couriers.inputs.total_cash_to_transfer')</x-shows.dt>
                        <x-shows.dd>@currency($closingCourier->total_cash_to_transfer)</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.closing_couriers.inputs.status')</x-shows.dt>
                        <x-shows.dd>
                            <x-spans.status-valid class="{{ $closingCourier->status_badge }}">
                                {{ $closingCourier->status_name }}
                            </x-spans.status-valid>
                        </x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>@lang('crud.closing_couriers.inputs.notes')</x-shows.dt>
                        <x-shows.dd>{{ $closingCourier->notes ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd>{{ $closingCourier->created_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd>{{ $closingCourier->updated_at ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('closing-couriers.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @can('view-any', App\Models\closing_courier_closing_store::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title"> Closing Stores </x-slot>

                    <livewire:closing-courier-closing-stores-detail :closingCourier="$closingCourier" />
                </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
