<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.utility_usages.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">laporan harian penggunaan listrik, air, dan internet masing-masing warung
        </p>
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
                @can('create', App\Models\UtilityUsage::class)
                    <a href="{{ route('utility-usages.create') }}">
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
                <x-tables.th-left>@lang('crud.utility_usages.inputs.store_id')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.utility_usages.inputs.date')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.utility_usages.inputs.utility_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.utility_usages.inputs.result')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.utility_usages.inputs.category')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.utility_usages.inputs.status')</x-tables.th-left-hide>
                @role('super-admin|supervisor|manager')
                    <x-tables.th-left-hide>@lang('crud.utility_usages.inputs.created_by_id')</x-tables.th-left-hide>
                @endrole
                @role('super-admin|staff')
                    <x-tables.th-left-hide>@lang('crud.utility_usages.inputs.approved_by_id')</x-tables.th-left-hide>
                @endrole
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($utilityUsages as $utilityUsage)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-main>
                            <x-slot name="main">
                                <div class="flex items-center">
                                    <div>
                                        @if ($utilityUsage->image == null)
                                            <x-partials.thumbnail src="" />
                                        @else
                                            <a href="{{ \Storage::url($utilityUsage->image) }}">
                                                <x-partials.thumbnail
                                                    src="{{ $utilityUsage->image ? \Storage::url($utilityUsage->image) : '' }}" />
                                            </a>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        {{ optional($utilityUsage->utility)->store->nickname ?? '-' }}
                                    </div>
                                </div>
                            </x-slot>
                            <x-slot name="sub">
                                <span>
                                    @if ($utilityUsage->utility->category == 1)
                                        <span>internet: </span>
                                    @elseif($utilityUsage->utility->category == 2)
                                        <span>listrik: </span>
                                    @elseif($utilityUsage->utility->category == 3)
                                        <span>air: </span>
                                    @endif
                                    {{ optional($utilityUsage->utility)->number ?? '-' }}
                                </span>
                                <span>result: {{ $utilityUsage->result ?? '-' }}
                                    {{ $utilityUsage->utility->unit->unit }}</span>
                                <span>date: {{ $utilityUsage->created_at }}</span>
                                <x-spans.status-valid class="{{ $utilityUsage->status_badge }}">
                                    {{ $utilityUsage->status_name }}
                                </x-spans.status-valid>
                            </x-slot>

                        </x-tables.td-left-main>
                        <x-tables.td-left-hide>{{ $utilityUsage->created_at }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($utilityUsage->utility)->number ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-right-hide>{{ $utilityUsage->result ?? '-' }}
                            {{ $utilityUsage->utility->unit->unit }}</x-tables.td-right-hide>
                        <x-tables.td-left-hide>
                            @if ($utilityUsage->utility->category == 1)
                                <span>internet</span>
                            @elseif($utilityUsage->utility->category == 2)
                                <span>listrik</span>
                            @elseif($utilityUsage->utility->category == 3)
                                <span>air</span>
                            @endif
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $utilityUsage->status_badge }}">
                                {{ $utilityUsage->status_name }}
                            </x-spans.status-valid>
                        </x-tables.td-left-hide>
                        @role('super-admin|supervisor|manager')
                            <x-tables.td-left-hide>{{ optional($utilityUsage->created_by)->name ?? '-' }}
                            </x-tables.td-left-hide>
                        @endrole
                        @role('super-admin|staff')
                            <x-tables.td-left-hide>{{ optional($utilityUsage->approved_by)->name ?? '-' }}
                            </x-tables.td-left-hide>
                        @endrole
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($utilityUsage->status != '2')
                                    <a href="{{ route('utility-usages.edit', $utilityUsage) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($utilityUsage->status == '2')
                                    <a href="{{ route('utility-usages.show', $utilityUsage) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $utilityUsage)
                                <form action="{{ route('utility-usages.destroy', $utilityUsage) }}" method="POST"
                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                    @csrf @method('DELETE')
                                    <x-buttons.delete></x-buttons.delete>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <x-tables.no-items-found colspan="10">
                </x-tables.no-items-found>
            @endforelse
        </x-slot>
        <x-slot name="foot"> </x-slot>
    </x-table>
</x-tables.card>
<div class="px-4 mt-10">{!! $utilityUsages->render() !!}</div>
</x-admin-layout>
