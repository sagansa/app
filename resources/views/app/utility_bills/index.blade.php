<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.utility_bills.index_title')
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
                @can('create', App\Models\UtilityBill::class)
                <a href="{{ route('utility-bills.create') }}"
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
                    >@lang('crud.utility_bills.inputs.image')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.utility_bills.inputs.utility_id')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.utility_bills.inputs.date')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.utility_bills.inputs.amount')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.utility_bills.inputs.initial_indicator')</x-tables.th-left
                >
                <x-tables.th-left
                    >@lang('crud.utility_bills.inputs.last_indicator')</x-tables.th-left
                >
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($utilityBills as $utilityBill)
                <tr class="hover:bg-gray-50">
                    <x-tables.td-left-hide>
                        @if ($utilityBill->image == null)
                        <x-partials.thumbnail src="" />
                        @else
                        <a href="{{ \Storage::url($utilityBill->image) }}">
                            <x-partials.thumbnail
                                src="{{ $utilityBill->image ? \Storage::url($utilityBill->image) : '' }}"
                            />
                        </a>
                        @endif
                    </x-tables.td-left-hide>

                    <x-tables.td-left-hide
                        >{{ optional($utilityBill->utility)->name ?? '-'
                        }}</x-tables.td-left-hide
                    >
                    <x-tables.td-left-hide
                        >{{ $utilityBill->date ?? '-' }}</x-tables.td-left-hide
                    >
                    <x-tables.td-right-hide
                        >{{ $utilityBill->amount ?? '-'
                        }}</x-tables.td-right-hide
                    >
                    <x-tables.td-right-hide
                        >{{ $utilityBill->initial_indicator ?? '-'
                        }}</x-tables.td-right-hide
                    >
                    <x-tables.td-right-hide
                        >{{ $utilityBill->last_indicator ?? '-'
                        }}</x-tables.td-right-hide
                    >
                    <td class="px-4 py-3 text-center" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @if($utilityBill->status != '2')
                            <a
                                href="{{ route('utility-bills.edit', $utilityBill) }}"
                                class="mr-1"
                            >
                                <x-buttons.edit></x-buttons.edit>
                            </a>
                            @elseif($utilityBill->status == '2')
                            <a
                                href="{{ route('utility-bills.show', $utilityBill) }}"
                                class="mr-1"
                            >
                                <x-buttons.show></x-buttons.show>
                            </a>
                            @endif @can('delete', $utilityBill)
                            <form
                                action="{{ route('utility-bills.destroy', $utilityBill) }}"
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
                <x-tables.no-items-found colspan="7"> </x-tables.no-items-found>
                @endforelse
            </x-slot>
            <x-slot name="foot"> </x-slot>
        </x-table>
    </x-tables.card>
    <div class="mt-10 px-4">{!! $utilityBills->render() !!}</div>
</x-admin-layout>
