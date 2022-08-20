<table>
    @foreach ($products as $product)
        <tr>
            <td>
                <x-input.hidden name="product_id" value="{{ old('product_id', $editing ? $product->id : '') }}">
                </x-input.hidden>
                <div class="mr-2 text-xs">{{ $product->name }} </div>
            </td>
            <td>
                <input
                    class="block w-full ml-2 text-xs text-right border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    value="{{ $product->value ?? null }}" data-id="{{ $product->id }}"
                    name="products[{{ $product->id }}]" type="number" class="product-quantity">
            </td>
            <td>
                <div class="ml-2 text-xs"> {{ $product->unit->unit }}</div>
            </td>
        </tr>
    @endforeach
</table>
