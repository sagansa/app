<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.vehicle_taxes.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">data pajak kendaraan</p>
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
                @can('create', App\Models\VehicleTax::class)
                    <a href="{{ route('vehicle-taxes.create') }}">
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
                <x-tables.th-left>@lang('crud.vehicle_taxes.inputs.image')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.vehicle_taxes.inputs.vehicle_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.vehicle_taxes.inputs.amount_tax')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.vehicle_taxes.inputs.expired_date')</x-tables.th-left>
                <x-tables.th-left>created by</x-tables.th-left>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($vehicleTaxes as $vehicleTax)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>
                            @if ($vehicleTax->image == null)
                                <x-partials.thumbnail src="" />
                            @else
                                <a href="{{ \Storage::url($vehicleTax->image) }}">
                                    <x-partials.thumbnail
                                        src="{{ $vehicleTax->image ? \Storage::url($vehicleTax->image) : '' }}" />
                                </a>
                            @endif
                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>{{ optional($vehicleTax->vehicle)->no_register ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-right-hide>@currency($vehicleTax->amount_tax)
                        </x-tables.td-right-hide>
                        <x-tables.td-left-hide>{{ $vehicleTax->expired_date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($vehicleTax->user)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($vehicleTax->status != '2')
                                    <a href="{{ route('vehicle-taxes.edit', $vehicleTax) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($vehicleTax->status == '2')
                                    <a href="{{ route('vehicle-taxes.show', $vehicleTax) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $vehicleTax)
                                <form action="{{ route('vehicle-taxes.destroy', $vehicleTax) }}" method="POST"
                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                    @csrf @method('DELETE')
                                    <x-buttons.delete></x-buttons.delete>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <x-tables.no-items-found colspan="5"> </x-tables.no-items-found>
            @endforelse
        </x-slot>
        <x-slot name="foot"> </x-slot>
    </x-table>
</x-tables.card>
<div class="px-4 mt-10">{!! $vehicleTaxes->render() !!}</div>
</x-admin-layout>
