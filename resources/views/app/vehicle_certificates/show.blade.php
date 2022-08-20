<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.vehicle_certificates.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a
                        href="{{ route('vehicle-certificates.index') }}"
                        class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-shows.dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_certificates.inputs.vehicle_id')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ optional($vehicleCertificate->vehicle)->image ??
                            '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_certificates.inputs.BPKB')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleCertificate->BPKB ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_certificates.inputs.STNK')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleCertificate->STNK ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_certificates.inputs.name')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleCertificate->name ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_certificates.inputs.brand')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleCertificate->brand ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_certificates.inputs.type')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleCertificate->type ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_certificates.inputs.category')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleCertificate->category ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_certificates.inputs.model')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleCertificate->model ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_certificates.inputs.manufacture_year')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleCertificate->manufacture_year ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_certificates.inputs.cylinder_capacity')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleCertificate->cylinder_capacity ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_certificates.inputs.vehilce_identity_no')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleCertificate->vehilce_identity_no ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_certificates.inputs.engine_no')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleCertificate->engine_no ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_certificates.inputs.color')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleCertificate->color ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_certificates.inputs.type_fuel')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleCertificate->type_fuel ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_certificates.inputs.lisence_plate_color')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleCertificate->lisence_plate_color ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_certificates.inputs.registration_year')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleCertificate->registration_year ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_certificates.inputs.bpkb_no')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleCertificate->bpkb_no ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_certificates.inputs.location_code')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleCertificate->location_code ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_certificates.inputs.registration_queue_no')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleCertificate->registration_queue_no ??
                            '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt
                            >@lang('crud.vehicle_certificates.inputs.notes')</x-shows.dt
                        >
                        <x-shows.dd
                            >{{ $vehicleCertificate->notes ?? '-' }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Created Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $vehicleCertificate->created_at ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                    <x-shows.sub-dl>
                        <x-shows.dt>Updated Date</x-shows.dt>
                        <x-shows.dd
                            >{{ $vehicleCertificate->updated_at ?? '-'
                            }}</x-shows.dd
                        >
                    </x-shows.sub-dl>
                </x-shows.dl>

                <div class="mt-10">
                    <a
                        href="{{ route('vehicle-certificates.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-admin-layout>
