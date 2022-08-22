<x-admin-layout>
    @role('staff|manager|supervisor')
        <x-slot name="header">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                @lang('crud.presences.index_title')
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
                    @can('create', App\Models\Presence::class)
                        <a href="{{ route('presences.create') }}">
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
                    <x-tables.th-left>@lang('crud.presences.inputs.closing_store_id')</x-tables.th-left>
                    <x-tables.th-left>Store</x-tables.th-left>
                    <x-tables.th-left-hide>Date</x-tables.th-left-hide>
                    <x-tables.th-left-hide>@lang('crud.presences.inputs.amount')</x-tables.th-left-hide>
                    <x-tables.th-left-hide>@lang('crud.presences.inputs.payment_type_id')</x-tables.th-left-hide>
                    <x-tables.th-left-hide>@lang('crud.presences.inputs.status')</x-tables.th-left-hide>
                    <x-tables.th-left-hide>@lang('crud.presences.inputs.created_by_id')</x-tables.th-left-hide>
                    <x-tables.th-left-hide>@lang('crud.presences.inputs.approved_by_id')</x-tables.th-left-hide>
                    <th></th>
                </x-slot>
                <x-slot name="body">
                    @forelse($presences as $presence)
                        <tr class="hover:bg-gray-50">
                            <x-tables.td-left-main>
                                <x-slot name="main"> {{ $presence->closingStore->store->nickname }} -
                                    {{ $presence->closingStore->shiftStore->name }}</x-slot>
                                <x-slot name="sub">
                                    <p> {{ optional($presence->closingStore)->date->toFormattedDate() ?? '-' }} -
                                        @currency($presence->amount)</p>
                                    <p>{{ optional($presence->paymentType)->name ?? '-' }}
                                        @if ($presence->status == 1)
                                            <x-spans.yellow>process</x-spans.yellow>
                                        @elseif ($presence->status == 2)
                                            <x-spans.green>done</x-spans.green>
                                        @elseif ($presence->status == 3)
                                            <x-spans.red>no need</x-spans.red>
                                        @endif
                                    </p>
                                </x-slot>

                            </x-tables.td-left-main>
                            <x-tables.td-left-hide>{{ optional($presence->closingStore)->date->toFormattedDate() ?? '-' }}
                            </x-tables.td-left-hide>

                            <x-tables.td-right-hide>@currency($presence->amount)</x-tables.td-right-hide>
                            <x-tables.td-left-hide>{{ optional($presence->paymentType)->name ?? '-' }}
                            </x-tables.td-left-hide>
                            <x-tables.td-left-hide>
                                @if ($presence->status == 1)
                                    <x-spans.yellow>process</x-spans.yellow>
                                @elseif ($presence->status == 2)
                                    <x-spans.green>done</x-spans.green>
                                @elseif ($presence->status == 3)
                                    <x-spans.red>no need</x-spans.red>
                                @endif
                            </x-tables.td-left-hide>
                            <x-tables.td-left-hide>{{ optional($presence->created_by)->name ?? '-' }}
                            </x-tables.td-left-hide>
                            <x-tables.td-left-hide>{{ optional($presence->approved_by)->name ?? '-' }}
                            </x-tables.td-left-hide>
                            <td class="px-4 py-3 text-center" style="width: 134px;">
                                <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                    @if ($presence->status != '2')
                                        <a href="{{ route('presences.edit', $presence) }}" class="mr-1">
                                            <x-buttons.edit></x-buttons.edit>
                                        </a>
                                    @elseif($presence->status == '2')
                                        <a href="{{ route('presences.show', $presence) }}" class="mr-1">
                                            <x-buttons.show></x-buttons.show>
                                        </a>
                                    @endif @can('delete', $presence)
                                    <form action="{{ route('presences.destroy', $presence) }}" method="POST"
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
    <div class="px-4 mt-10">{!! $presences->render() !!}</div>
@endrole
@role('super-admin')
    <livewire:presences.presences-list />
@endrole
</x-admin-layout>
