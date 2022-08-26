<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.productions.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">produksi bahan baku mentah menjadi bahan baku siap dijual atau disajikan
            sebelum diproses lebih lanjut</p>
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
                @can('create', App\Models\Production::class)
                    <a href="{{ route('productions.create') }}">
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
                <x-tables.th-left>@lang('crud.productions.inputs.store_id')</x-tables.th-left>
                <x-tables.th-left-hide>@lang('crud.productions.inputs.date')</x-tables.th-left-hide>
                <x-tables.th-left-hide>FROM PRODUCT</x-tables.th-left-hide>
                <x-tables.th-left-hide>TO PRODUCT</x-tables.th-left-hide>
                <x-tables.th-left-hide>@lang('crud.productions.inputs.status')</x-tables.th-left-hide>
                @role('super-admin|manager|supervisor')
                    <x-tables.th-left-hide>@lang('crud.productions.inputs.created_by_id')</x-tables.th-left-hide>
                @endrole
                @role('staff|super-admin|manager')
                    <x-tables.th-left-hide>@lang('crud.productions.inputs.approved_by_id')</x-tables.th-left-hide>
                @endrole
                <th></th>
            </x-slot>
            <x-slot name="body">
                @forelse($productions as $production)
                    <tr class="hover:bg-gray-50">
                        <x-tables.td-left-main>
                            <x-slot name="main">{{ optional($production->store)->nickname ?? '-' }}</x-slot>
                            <x-slot name="sub">
                                <p>date: {{ $production->date->toFormattedDate() ?? '-' }}</p>
                                <x-spans.status-valid class="{{ $production->status_badge }}">
                                    {{ $production->status_name }}
                                </x-spans.status-valid>
                                @role('super-admin|manager|supervisor')
                                    <p>created: {{ optional($production->created_by)->name ?? '-' }}</p>
                                @endrole
                                @role('staff|super-admin|manager')
                                    <p>approved: {{ optional($production->approved_by)->name ?? '-' }}</p>
                                @endrole
                            </x-slot>

                        </x-tables.td-left-main>
                        <x-tables.td-left-hide>{{ $production->date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            <div class="font-bold">Main</div>
                            @foreach ($production->productionFroms as $productionFrom)
                                <p> {{ $productionFrom->purchaseOrderProduct->product->name }} =
                                    {{ $productionFrom->purchaseOrderProduct->quantity_product }}
                                    {{ $productionFrom->purchaseOrderProduct->product->unit->unit }}</p>
                            @endforeach
                            <div class="font-bold">Support</div>
                            @foreach ($production->productionSupportFroms as $productionSupportFrom)
                                <p>{{ $productionSupportFrom->product->name }} =
                                    {{ $productionSupportFrom->quantity }}
                                    {{ $productionSupportFrom->product->unit->unit }}</p>
                            @endforeach

                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>

                            @foreach ($production->productionTos as $productionTo)
                                <p>{{ $productionTo->product->name }} = {{ $productionTo->quantity }}
                                    {{ $productionTo->product->unit->unit }}</p>
                            @endforeach

                        </x-tables.td-left-hide>
                        <x-tables.td-left-hide>
                            <x-spans.status-valid class="{{ $production->status_badge }}">
                                {{ $production->status_name }}
                            </x-spans.status-valid>
                        </x-tables.td-left-hide>
                        @role('super-admin|manager|supervisor')
                            <x-tables.td-left-hide>
                                {{ optional($production->created_by)->name ?? '-' }}
                            </x-tables.td-left-hide>
                        @endrole
                        @role('staff|super-admin|manager')
                            <x-tables.td-left-hide>
                                {{ optional($production->approved_by)->name ?? '-' }}
                            </x-tables.td-left-hide>
                        @endrole
                        <td class="px-4 py-3 text-center" style="width: 134px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($production->status != '2')
                                    <a href="{{ route('productions.edit', $production) }}" class="mr-1">
                                        <x-buttons.edit></x-buttons.edit>
                                    </a>
                                @elseif($production->status == '2')
                                    <a href="{{ route('productions.show', $production) }}" class="mr-1">
                                        <x-buttons.show></x-buttons.show>
                                    </a>
                                @endif
                                @can('delete', $production)
                                    <form action="{{ route('productions.destroy', $production) }}" method="POST"
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
    <div class="px-4 mt-10">{!! $productions->render() !!}</div>
</x-admin-layout>
