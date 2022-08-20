<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.out_in_products.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">diisi setiap ada barang yang masuk atau keluar</p>
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
                @can('create', App\Models\OutInProduct::class)
                    <a href="{{ route('out-in-products.create') }}">
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
                <x-tables.th-left-hide>@lang('crud.out_in_products.inputs.image')</x-tables.th-left-hide>
                <x-tables.th-left>@lang('crud.out_in_products.inputs.stock_card_id')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.out_in_products.inputs.out_in')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.out_in_products.inputs.to_from')</x-tables.th-left-hide>
                <x-tables.th-left-hide>product</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.out_in_products.inputs.status')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.out_in_products.inputs.created_by_id')</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.out_in_products.inputs.approved_by_id')</x-tables.th-left-hide>
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($outInProducts as $outInProduct)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-hide>
                            @if ($outInProduct->image == null)
                                <x-partials.thumbnail src="" />
                            @else
                                <a href="{{ \Storage::url($outInProduct->image) }}">
                                    <x-partials.thumbnail
                                        src="{{ $outInProduct->image ? \Storage::url($outInProduct->image) : '' }}" />
                                </a>
                            @endif
                        </x-tables.td-left-hide>

                        <x-tables.td-left-main>
                            <x-slot name="main">
                                <a href="{{ \Storage::url($outInProduct->image) }}">
                                    {{ optional($outInProduct->stockCard)->date->toFormattedDate() ?? '-' }}
                                    - {{ $outInProduct->stockCard->store->nickname }}
                                </a>
                            </x-slot>
                            <x-slot name="sub">
                                @if ($outInProduct->out_in == 1)
                                    <x-spans.red>keluar</x-spans.red>
                                @else
                                    <x-spans.green>masuk</x-spans.green>
                                @endif
                                <p>{{ $outInProduct->to_from ?? '-' }}</p>
                                <x-spans.status-valid class="{{ $outInProduct->status_badge }}">
                                    {{ $outInProduct->status_name }}
                                </x-spans.status-valid>
                                <p>created: {{ optional($outInProduct->created_by)->name ?? '-' }}</p>
                                <p>approved: {{ optional($outInProduct->approved_by)->name ?? '-' }}</p>
                            </x-slot>
                        </x-tables.td-left-main>
                        <x-tables.td-left-hide>
                            @if ($outInProduct->out_in == 1)
                                <x-spans.red>keluar</x-spans.red>
                            @else
                                <x-spans.green>masuk</x-spans.green>
                            @endif
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ $outInProduct->to_from ?? '-' }}</x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            @foreach ($outInProduct->products as $key => $products)
                                <div class="label label-info">{{ $products->name }}
                                    = {{ $products->pivot->quantity }} {{ $products->unit->unit }}
                                </div>
                            @endforeach
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $outInProduct->status_badge }}">
                                {{ $outInProduct->status_name }}
                            </x-spans.status-valid>
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($outInProduct->created_by)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>{{ optional($outInProduct->approved_by)->name ?? '-' }}
                        </x-tables.td-left-hide>
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($outInProduct->status != '2')
                                    <a href="{{ route('out-in-products.edit', $outInProduct) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($outInProduct->status == '2')
                                    <a href="{{ route('out-in-products.show', $outInProduct) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif @can('delete', $outInProduct)
                                <form action="{{ route('out-in-products.destroy', $outInProduct) }}" method="POST"
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
<div class="px-4 mt-10">{!! $outInProducts->render() !!}</div>
</x-admin-layout>
