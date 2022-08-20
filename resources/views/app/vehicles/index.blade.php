<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.vehicles.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">---</p>
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
                @can('create', App\Models\Vehicle::class)
                    <a href="{{ route('vehicles.create') }}">
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
                <x-tables.th-left>@lang('crud.vehicles.inputs.image')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.vehicles.inputs.no_register')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.vehicles.inputs.type')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.vehicles.inputs.store_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.vehicles.inputs.user_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.vehicles.inputs.status')</x-tables.th-left>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($vehicles as $vehicle)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>
                            @if ($vehicle->image == null)
                                <x-partials.thumbnail src="" />
                            @else
                                <a href="{{ \Storage::url($vehicle->image) }}">
                                    <x-partials.thumbnail
                                        src="{{ $vehicle->image ? \Storage::url($vehicle->image) : '' }}" />
                                </a>
                            @endif
                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>{{ $vehicle->no_register ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @if ($vehicle->type == 1)
                                <p>motor</p>
                            @elseif($vehicle->type == 2)
                                <p>mobil</p>
                            @else
                                <p>truk</p>
                            @endif
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($vehicle->store)->name ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($vehicle->user)->name ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $vehicle->status_badge }}">
                                {{ $vehicle->status_name }}
                            </x-spans.status-valid>
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                <a href="{{ route('vehicles.edit', $vehicle) }}" class="mr-1">
                                    <x-buttons.edit></x-buttons.edit>
                                </a>
                                @can('delete', $vehicle)
                                    <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
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
    <div class="px-4 mt-10">{!! $vehicles->render() !!}</div>
</x-admin-layout>
