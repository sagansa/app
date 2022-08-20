<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.transfer_stocks.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">transfer bahan baku dari satu warung ke warung yang lain</p>
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
                @can('create', App\Models\TransferStock::class)
                    <a href="{{ route('transfer-stocks.create') }}">
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
                <x-tables.th-left>@lang('crud.transfer_stocks.inputs.date')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.transfer_stocks.inputs.from_store_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.transfer_stocks.inputs.to_store_id')</x-tables.th-left>
                <x-tables.th-left>Product</x-tables.th-left>
                <x-tables.th-left>@lang('crud.transfer_stocks.inputs.status')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.transfer_stocks.inputs.received_by_id')</x-tables.th-left>
                <x-tables.th-left>@lang('crud.transfer_stocks.inputs.sent_by_id')</x-tables.th-left>
                @role('super-admin|supervisor|manager')
                    <x-tables.th-left>@lang('crud.transfer_stocks.inputs.approved_by_id')</x-tables.th-left>
                @endrole
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($transferStocks as $transferStock)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>{{ $transferStock->date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($transferStock->from_store)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($transferStock->to_store)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @foreach ($transferStock->products as $product)
                                <div>
                                    {{ $product->name }} = {{ $product->pivot->quantity }}
                                    {{ $product->unit->unit }}
                                </div>
                            @endforeach
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $transferStock->status_badge }}">
                                {{ $transferStock->status_name }}
                            </x-spans.status-valid>
                        </x-tables.td-left-hide>

                        <x-tables.td-left-hide>{{ optional($transferStock->received_by)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($transferStock->sent_by)->name ?? '-' }}
                        </x-tables.td-left-hide>

                        @role('super-admin|supervisor|manager')
                            <x-tables.td-left-hide>{{ optional($transferStock->approved_by)->name ?? '-' }}
                            </x-tables.td-left-hide>
                        @endrole
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($transferStock->status != '2')
                                    <a href="{{ route('transfer-stocks.edit', $transferStock) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($transferStock->status == '2')
                                    <a href="{{ route('transfer-stocks.show', $transferStock) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $transferStock)
                                <form action="{{ route('transfer-stocks.destroy', $transferStock) }}" method="POST"
                                    onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')">
                                    @csrf @method('DELETE')
                                    <x-buttons.delete></x-buttons.delete>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <x-tables.no-items-found colspan="8"> </x-tables.no-items-found>
            @endforelse
        </x-slot>
        <x-slot name="foot"> </x-slot>
    </x-table>
</x-tables.card>
<div class="px-4 mt-10">{!! $transferStocks->render() !!}</div>
</x-admin-layout>
