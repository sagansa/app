<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.productions.index_title')
        </h2>
        <p class="mt-2 text-xs text-gray-700">produksi bahan baku mentah menjadi bahan baku siap dijual atau disajikan
            sebelum diproses lebih lanjut</p>
    </x-slot>

    <x-tables.topbar>
        <x-slot name="search">
            <x-buttons.link wire:click.prevent="$toggle('showFilters')">
                @if ($showFilters)
                    Hide
                @endif Advanced Search...
            </x-buttons.link>
            @if ($showFilters)
                <x-filters.group>
                    <x-filters.label>Store</x-filters.label>
                    <x-filters.select wire:model="filters.store_id">
                        @foreach ($stores as $label => $value)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>

                <x-filters.group>
                    <x-filters.label>Status</x-filters.label>
                    <x-filters.select wire:model="filters.status">
                        @foreach (App\Models\Production::STATUSES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filters.select>
                </x-filters.group>

                <x-buttons.link wire:click.prevent="resetFilters">Reset Filter
                </x-buttons.link>
            @endif
        </x-slot>
        <x-slot name="action">
            <div class="flex flex-wrap justify-between mt-1">
                <div class="mt-1 md:w-1/3">
                    @role('super-admin')
                        <x-buttons.green wire:click.prevent="markAllAsValid">Valid</x-buttons.green>
                        <x-buttons.yellow wire:click.prevent="markAllAsBelumDiperiksa">Belum Diperiksa</x-buttons.yellow>
                        <x-buttons.red wire:click.prevent='markAllAsPerbaiki'>Perbaiki</x-buttons.red>
                    @endrole
                </div>
                <div class="mt-1 text-right md:w-1/3">
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
        </x-slot>

    </x-tables.topbar>

    <x-tables.card>
        <x-table>
            <x-slot name="head">
                @role('super-admin')
                    <th></th>
                @endrole
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
                        @role('super-admin')
                            <x-tables.td-checkbox id="{{ $production->id }}"></x-tables.td-checkbox>
                        @endrole
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
                                <p> {{ optional($productionFrom->purchaseOrderProduct)->product->name ?? '-' }} =
                                    {{ optional($productionFrom->purchaseOrderProduct)->quantity_product ?? '-' }}
                                    {{ optional($productionFrom->purchaseOrderProduct)->product->unit->unit ?? '-' }}
                                </p>
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
</div>
