<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.vehicle_certificates.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">Detail data STNK kendaraan bermotor</p>
    </x-slot>

    <div class="mt-4 mb-5">
        <div class="flex flex-wrap justify-between mt-1">
            <div class="mt-1 md:w-1/3">
                <form>
                    <div class="flex items-center w-full">
                        <x-inputs.text name="search" value="{{ $search ?? '' }}"
                            placeholder="{{ __('crud.common.search') }}" autocomplete="off"></x-inputs.text>

                        <div class="ml-1">
                            <x-jet-button>
                                <i class="icon ion-md-search"></i>
                            </x-jet-button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="mt-1 text-right md:w-1/3">
                @can('create', App\Models\VehicleCertificate::class)
                    <a href="{{ route('vehicle-certificates.create') }}">
                        <x-jet-button>
                            <i class="mr-1 icon ion-md-add"></i>
                            @lang('crud.common.create')
                        </x-jet-button>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <x-tables.th-left>@lang('crud.vehicle_certificates.inputs.vehicle_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.vehicle_certificates.inputs.BPKB')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.vehicle_certificates.inputs.STNK')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.vehicle_certificates.inputs.name')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.vehicle_certificates.inputs.brand')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.vehicle_certificates.inputs.manufacture_year')</x-tables.th-left>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($vehicleCertificates as $vehicleCertificate)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>{{ optional($vehicleCertificate->vehicle)->no_register ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @if ($vehicleCertificate->BPKB == 1)
                                <p>ada</p>
                            @else
                                <p>hilang</p>
                            @endif
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @if ($vehicleCertificate->STNK == 1)
                                <p>ada</p>
                            @else
                                <p>hilang</p>
                            @endif
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $vehicleCertificate->name ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $vehicleCertificate->brand ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $vehicleCertificate->manufacture_year ?? '-' }}
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($vehicleCertificate->status != '2')
                                    <a href="{{ route('vehicle-certificates.edit', $vehicleCertificate) }}"
                                        class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($vehicleCertificate->status == '2')
                                    <a href="{{ route('vehicle-certificates.show', $vehicleCertificate) }}"
                                        class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $vehicleCertificate)
                                <form action="{{ route('vehicle-certificates.destroy', $vehicleCertificate) }}"
                                    method="POST" onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                    @csrf @method('DELETE')
                                    <x-buttons.delete></x-buttons.delete>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <x-tables.no-items-found colspan="7"> </x-tables.no-items-found>
            @endforelse
        </x-slot>
        <x-slot name="foot"> </x-slot>
    </x-table>
</x-tables.card>
<div class="px-4 mt-10">{!! $vehicleCertificates->render() !!}</div>
</x-admin-layout>
