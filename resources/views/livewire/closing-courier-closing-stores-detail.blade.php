<div>
    <div>
        @if ($closingCourier->status != 2)
            @can('create', App\Models\ClosingCourier::class)
                <button class="button" wire:click="newClosingStore">
                    <i class="mr-1 icon ion-md-add text-primary"></i>
                    @lang('crud.common.attach')
                </button>
            @endcan
        @endif
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div>
                    <x-input.select name="closing_store_id" label="Closing Store" wire:model="closing_store_id">
                        <option value="null" disabled>-- select --</option>
                        @foreach ($closingStoresForSelect as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-input.select>
                </div>
            </div>
        </div>

        <div class="flex justify-between px-6 py-4 bg-gray-50">
            {{-- <button type="button" class="button" wire:click="$toggle('showingModal')">
                <i class="mr-1 icon ion-md-close"></i>
                @lang('crud.common.cancel')
            </button>

            <button type="button" class="button button-primary" wire:click="save">
                <i class="mr-1 icon ion-md-save"></i>
                @lang('crud.common.save')
            </button> --}}

            <x-buttons.secondary wire:click="$toggle('showingModal')">@lang('crud.common.cancel')</x-buttons.secondary>
            <x-jet-button wire:click="save">@lang('crud.common.save')</x-jet-button>
        </div>
    </x-modal>

    <x-tables.card-overflow>
        <x-table>
            <x-slot name="head">
                <tr>
                    <x-tables.th-left>
                        {{-- @lang('crud.closing_courier_closing_stores.inputs.closing_store_id') --}}
                        Date
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Store
                    </x-tables.th-left>
                    <x-tables.th-left>
                        Shift
                    </x-tables.th-left>
                    @role('super-admin')
                        <x-tables.th-left>
                            Transfer By
                        </x-tables.th-left>
                    @endrole
                    <x-tables.th-left>
                        Total Cash Transfer
                    </x-tables.th-left>
                    <th></th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($closingCourierClosingStores as $closingStore)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            {{ $closingStore->date->toFormattedDate() ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $closingStore->store->nickname ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $closingStore->shiftStore->name ?? '-' }}
                        </x-tables.td-left>
                        @role('super-admin')
                            <x-tables.td-left>
                                {{ $closingStore->transfer_by->name ?? '-' }}
                            </x-tables.td-left>
                        @endrole
                        <x-tables.td-right>
                            @currency($closingStore->total_cash_transfer)
                        </x-tables.td-right>
                        <td class="px-4 py-3 text-right" style="width: 70px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($closingCourier->status != 2)
                                    @can('delete-any', App\Models\ClosingCourier::class)
                                        <button class="button button-danger"
                                            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                            wire:click="detach({{ $closingStore->id }})">
                                            <i class="icon ion-md-trash text-primary"></i>

                                        </button>
                                    @endcan
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <x-tables.th-total colspan="3">Totals</x-tables.th-total>
                    <x-tables.td-total>@currency($this->totals)</x-tables.td-total>
                </tr>
                <tr>
                    <x-tables.th-total colspan="3">Total Transfer</x-tables.th-total>
                    @if ($closingCourier->status != 2)
                        <x-input.wire-currency name="total_cash_to_transfer" wiresubmit="updatePurchaseReceipt"
                            wiremodel="state.total_cash_to_transfer"></x-input.wire-currency>
                    @else
                        <x-tables.td-total>@currency($this->closingCourier->total_cash_to_transfer)</x-tables.td-total>
                    @endif
                </tr>
                <tr>
                    <x-tables.th-total colspan="3">Difference</x-tables.th-total>
                    <x-tables.td-total>
                        @if ($this->difference < 0)
                            <x-spans.text-red>@currency($this->difference) </x-spans.text-red>
                        @else
                            <x-spans.text-green>@currency($this->difference) </x-spans.text-green>
                        @endif
                    </x-tables.td-total>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="px-4 mt-10">
                            {{ $closingCourierClosingStores->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
