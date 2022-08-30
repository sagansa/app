<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.transfer_fuel_services.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a
                        href="{{ route('transfer-fuel-services.index') }}"
                        class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.transfer_fuel_services.inputs.image')</x-shows.dt
                        >
                        @if ($transferFuelService->image != null)
                        <x-partials.thumbnail src="" size="150" />
                        @else
                        <a
                            href="{{ \Storage::url($transferFuelService->image) }}"
                        >
                            <x-partials.thumbnail
                                src="{{ $transferFuelService->image ? \Storage::url($transferFuelService->image) : '' }}"
                                size="150"
                            />
                        </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.transfer_fuel_services.inputs.amount')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $transferFuelService->amount ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $transferFuelService->created_at ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $transferFuelService->updated_at ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a
                        href="{{ route('transfer-fuel-services.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>

            @can('view-any',
            App\Models\fuel_service_transfer_fuel_service::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Fuel Services </x-slot>

                <livewire:transfer-fuel-service-fuel-services-detail
                    :transferFuelService="$transferFuelService"
                />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-admin-layout>
