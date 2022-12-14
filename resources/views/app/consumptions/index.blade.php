<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.consumptions.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">---</p>
    </x-slot>

    <div class="mt-4 mb-5">
        <div class="flex flex-wrap justify-between mt-1">
            <div class="md:w-1/3">
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
            <div class="text-right md:w-1/3">
                @can('create', App\Models\Consumption::class)
                    <a href="{{ route('consumptions.create') }}">
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
                <x-tables.th-left>@lang('crud.consumptions.inputs.store_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.consumptions.inputs.date')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.consumptions.inputs.status')</x-tables.th-left>
                <x-tables.th-left>Detail</x-tables.th-left>
                <x-tables.th-left>@lang('crud.consumptions.inputs.created_by_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.consumptions.inputs.approved_by_id')</x-tables.th-left>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($consumptions as $consumption)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>{{ optional($consumption->store)->name ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $consumption->date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $consumption->status ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{-- @foreach ($consumption->products as $key => $products)
                                <div class="label label-info">{{ $products->name }}
                                    ({{ $products->pivot->quantity }})
                                </div>
                            @endforeach --}}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($consumption->created_by)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($consumption->approved_by)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($consumption->status != '2')
                                    <a href="{{ route('consumptions.edit', $consumption) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($consumption->status == '2')
                                    <a href="{{ route('consumptions.show', $consumption) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $consumption)
                                <form action="{{ route('consumptions.destroy', $consumption) }}" method="POST"
                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                    @csrf @method('DELETE')
                                    <x-buttons.delete></x-buttons.delete>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <x-tables.no-items-found colspan="6"> </x-tables.no-items-found>
            @endforelse
        </x-slot>
        <x-slot name="foot"> </x-slot>
    </x-table>
</x-tables.card>
<div class="px-4 mt-10">{!! $consumptions->render() !!}</div>
</x-admin-layout>
