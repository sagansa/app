<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.transfer_daily_salaries.index_title')
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
                @can('create', App\Models\TransferDailySalary::class)
                    <a href="{{ route('transfer-daily-salaries.create') }}">
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
                <x-tables.th-left>@lang('crud.transfer_daily_salaries.inputs.image')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.transfer_daily_salaries.inputs.amount')</x-tables.th-left>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($transferDailySalaries as $transferDailySalary)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>
                            @if ($transferDailySalary->image == null)
                                <x-partials.thumbnail src="" />
                            @else
                                <a href="{{ \Storage::url($transferDailySalary->image) }}">
                                    <x-partials.thumbnail
                                        src="{{ $transferDailySalary->image ? \Storage::url($transferDailySalary->image) : '' }}" />
                                </a>
                            @endif
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            {{-- {{ $transferDailySalary->presences->sum('amount') }} --}}
                            {{-- @foreach ($transferDailySalary->presences as $presence) --}}
                            {{-- <p> {{ $presence->created_by->name }}</p> --}}
                            {{-- <p>{{ $presence->sum('amount') }}</p> --}}
                            {{-- @endforeach --}}
                        </x-tables.td-left-hide>

                        <x-tables.td-right-hide>{{ $transferDailySalary->amount ?? '-' }}</x-tables.td-right-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @can('update', $transferDailySalary)
                                    <a href="{{ route('transfer-daily-salaries.edit', $transferDailySalary) }}"
                                        class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @endcan

                                <a href="{{ route('transfer-daily-salaries.show', $transferDailySalary) }}"
                                    class="mr-1">
                                    <x-buttons.show></x-buttons.show>
                                </a>
                                @can('delete', $transferDailySalary)
                                    <form action="{{ route('transfer-daily-salaries.destroy', $transferDailySalary) }}"
                                        method="POST" onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                        @csrf @method('DELETE')
                                        <x-buttons.delete></x-buttons.delete>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <x-tables.no-items-found colspan="3"> </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="px-4 mt-10">{!! $transferDailySalaries->render() !!}</div>
</x-admin-layout>
