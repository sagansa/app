<div>
    <div>
        @if ($outInProduct->status != '2')
            @can('create', App\Models\OutInProduct::class)
                <button class="button" wire:click="newProduct">
                    <i class="mr-1 icon ion-md-add text-primary"></i>
                    @lang('crud.common.attach')
                </button>
            @endcan
        @endif
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">

                <x-input.select name="product_id" label="Product" wire:model="product_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($productsForSelect as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach

                    {{-- @foreach ($productsForSelect as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->unit->unit }}</option>
                    @endforeach --}}
                </x-input.select>

                <x-input.number name="quantity" label="Quantity" wire:model="quantity" step="0.01">
                </x-input.number>

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

            <x-buttons.secondary wire:click="$toggle('showingModal')">Cancel</x-buttons.secondary>
            <x-jet-button wire:click="save">Save</x-jet-button>
        </div>
    </x-modal>

    <x-tables.card-overflow>
        <x-table>
            <x-slot name="head">
                <tr>
                    <x-tables.th-left>
                        @lang('crud.out_in_product_products.inputs.product_id')
                    </x-tables.th-left>
                    <x-tables.th-left>
                        @lang('crud.out_in_product_products.inputs.quantity')
                    </x-tables.th-left>
                    @if ($outInProduct->status != '2')
                        <th></th>
                    @endif
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach ($outInProductProducts as $product)
                    <tr class="hover:bg-gray-100">
                        <x-tables.td-left>
                            {{ $product->name ?? '-' }}
                        </x-tables.td-left>
                        <x-tables.td-left>
                            {{ $product->pivot->quantity ?? '-' }} {{ $product->unit->unit }}
                        </x-tables.td-left>
                        <td class="px-4 py-3 text-right" style="width: 70px;">
                            <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                @if ($outInProduct->status != '2')
                                    <button class="button button-danger"
                                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                        wire:click="detach({{ $product->id }})">
                                        <i class="icon ion-md-trash text-primary"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
            <x-slot name="foot">
                <tr>
                    <td colspan="3">
                        <div class="px-4 mt-10">
                            {{ $outInProductProducts->render() }}
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table>
    </x-tables.card-overflow>
</div>
