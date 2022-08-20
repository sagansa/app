<div>
    <div>
        @if ($closingStore->transfer_status != 2 || $closingStore->closing_status != 2)
            @can('delete-any', App\Models\Presence::class)
                <button class="button button-danger" {{ empty($selected) ? 'disabled' : '' }}
                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="destroySelected">
                    <i class="mr-1 icon ion-md-trash text-primary"></i>
                    @lang('crud.common.delete_selected')
                </button>
            @endcan
        @endif
    </div>

    <x-tables.card-overflow>
        <x-table>
            <x-slot name="head">
                <tr>
                    @if ($closingStore->transfer_status != 2 || $closingStore->closing_status != 2)
                        <th class="w-1 px-4 py-3 text-left">
                            <input type="checkbox" wire:model="allSelected" wire:click="toggleFullSelection"
                                title="{{ trans('crud.common.select_all') }}" />
                        </th>
                    @endif
                    <x-tables.th-left>
                        Name
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.closing_store_presences.inputs.amount')
                    </x-tables.th-left>

                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($presences as $presence)
                    <tr class="hover:bg-gray-100">
                        @if ($closingStore->transfer_status != 2 || $closingStore->closing_status != 2)
                            <x-tables.td-left>
                                <input type="checkbox" value="{{ $presence->id }}" wire:model="selected" />
                            </x-tables.td-left>
                        @endif
                        <x-tables.td-left>
                            {{ $presence->created_by->name }}
                        </x-tables.td-left>
                        <x-tables.td-right>
                            @currency($presence->amount)
                        </x-tables.td-right>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <th scope="row" colspan="2"
                        class="pt-1 pl-6 pr-3 text-xs font-semibold text-right text-gray-900 sm:table-cell md:pl-0">
                        Totals</th>

                    <td class="relative py-2 pl-3 pr-4 text-xs font-semibold text-right text-gray-500 sm:pr-6">
                        {{-- @currency($this->totals) --}}
                        @currency($presences->sum('amount'))
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="px-4 mt-10">{{ $presences->render() }}</div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
