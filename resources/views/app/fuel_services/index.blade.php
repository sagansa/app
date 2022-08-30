<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.fuel_services.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">---</p>
    </x-slot>

    <div class="mb-5 mt-4">
        <div class="flex flex-wrap justify-between mt-1">
            <div class="mt-1 md:w-1/3">
                <form>
                    <div class="flex items-center w-full">
                        <x-inputs.text
                            name="search"
                            value="{{ $search ?? '' }}"
                            placeholder="{{ __('crud.common.search') }}"
                            autocomplete="off"
                        ></x-inputs.text>

                        <div class="ml-1">
                            <x-jet-button>
                                <i class="icon ion-md-search"></i>
                            </x-jet-button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="mt-1 md:w-1/3 text-right">
                @can('create', App\Models\FuelService::class)
                <a href="{{ route('fuel-services.create') }}"
                    ><x-jet-button>
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')</x-jet-button
                    >
                </a>
                @endcan
            </div>
        </div>
    </div>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                <x-tables.th-left
                    >@lang('crud.fuel_services.inputs.image')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.fuel_services.inputs.vehicle_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.fuel_services.inputs.fuel_service')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.fuel_services.inputs.payment_type_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.fuel_services.inputs.km')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.fuel_services.inputs.liter')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.fuel_services.inputs.amount')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.fuel_services.inputs.closing_store_id')</x-tables.th-left
                >
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($fuelServices as $fuelService)
                <tr class="hover:bg-gray-50">
                    <x-tables.td-left-hide>
                        @if ($fuelService->image == null)
                        <x-partials.thumbnail src="" />
                        @else
                        <a href="{{ \Storage::url($fuelService->image) }}">
                            <x-partials.thumbnail
                                src="{{ $fuelService->image ? \Storage::url($fuelService->image) : '' }}"
                            />
                        </a>
                        @endif
                    </x-tables.td-left-hide>

                    <x-tables.td-left-hide
                        >{{ optional($fuelService->vehicle)->image ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $fuelService->fuel_service ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($fuelService->paymentType)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-right-hide
                        >{{ $fuelService->km ?? '-' }}</x-tables.td-right-hide
                    >
                    <x-tables.td-right-hide
                        >{{ $fuelService->liter ?? '-'
                        }}</x-tables.td-right-hide
                    >
                    <x-tables.td-right-hide
                        >{{ $fuelService->amount ?? '-'
                        }}</x-tables.td-right-hide
                    >
                    <x-tables.td-left-hide
                        >{{ optional($fuelService->closingStore)->date ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <td class="px-4 py-3 text-center" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @if($fuelService->status != '2')
                            <a
                                href="{{ route('fuel-services.edit', $fuelService) }}"
                                class="mr-1"
                            >
                                <x-buttons.edit></x-buttons.edit>
                            </a>
                            @elseif($fuelService->status == '2')
                            <a
                                href="{{ route('fuel-services.show', $fuelService) }}"
                                class="mr-1"
                            >
                                <x-buttons.show></x-buttons.show>
                            </a>
                            @endif @can('delete', $fuelService)
                            <form
                                action="{{ route('fuel-services.destroy', $fuelService) }}"
                                method="POST"
                                onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                            >
                                @csrf @method('DELETE')
                                <x-buttons.delete></x-buttons.delete>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <x-tables.no-items-found colspan="9"> </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="mt-10 px-4">{!! $fuelServices->render() !!}</div>
</x-admin-layout>
