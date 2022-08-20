<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.vehicle_taxes.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('vehicle-taxes.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_taxes.inputs.image')</x-shows.dt
                        >
                        @if ($vehicleTax->image != null)
                        <x-partials.thumbnail src="" size="150" />
                        @else
                        <a href="{{ \Storage::url($vehicleTax->image) }}">
                            <x-partials.thumbnail
                                src="{{ $vehicleTax->image ? \Storage::url($vehicleTax->image) : '' }}"
                                size="150"
                            />
                        </a>
                        @endif
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_taxes.inputs.vehicle_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($vehicleTax->vehicle)->image ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_taxes.inputs.amount_tax')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleTax->amount_tax ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_taxes.inputs.expired_date')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleTax->expired_date ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_taxes.inputs.notes')</x-shows.dt
                        >
                        <x-shows.dd>{{ $vehicleTax->notes ?? '-' }}</x-shows.dd>
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $vehicleTax->created_at ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $vehicleTax->updated_at ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a href="{{ route('vehicle-taxes.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-admin-layout>
