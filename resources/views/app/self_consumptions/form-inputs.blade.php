@php $editing = isset($selfConsumption) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.select name="store_id" label="Store" required>
        @php $selected = old('store_id', ($editing ? $selfConsumption->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($stores as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.date name="date" label="Date"
        value="{{ old('date', $editing ? optional($selfConsumption->date)->format('Y-m-d') : '') }}" required>
    </x-input.date>

    @if ($editing)
        @role('super-admin')
            <x-input.select name="status" label="Status">
                @php $selected = old('status', ($editing ? $selfConsumption->status : '1')) @endphp
                <option value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diperiksa</option>
                <option value="2" {{ $selected == '2' ? 'selected' : '' }}>valid</option>
                <option value="3" {{ $selected == '3' ? 'selected' : '' }}>perbaiki</option>
                <option value="4" {{ $selected == '4' ? 'selected' : '' }}>periksa ulang</option>
            </x-input.select>
        @endrole

        @role('staff|manager|supervisor')
            @if ($selfConsumption->approved_by_id != null)
                <x-input.select name="status" label="Status">
                    @php $selected = old('status', ($editing ? $selfConsumption->status : '1')) @endphp
                    <option disabled value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diperiksa</option>
                    <option disabled value="3" {{ $selected == '3' ? 'selected' : '' }}>perbaiki</option>
                    <option value="4" {{ $selected == '4' ? 'selected' : '' }}>periksa ulang</option>
                </x-input.select>
            @else
                <x-input.hidden name="status" value="{{ old('status', $editing ? $selfConsumption->status : '1') }}">
                </x-input.hidden>
            @endif
        @endrole
    @endif

    @if (!$editing)
        <x-input.hidden name="status" value="{{ old('status', $editing ? $selfConsumption->status : '1') }}">
        </x-input.hidden>
    @endif

    <x-input.textarea name="notes" label="Notes" maxlength="255">
        {{ old('notes', $editing ? $selfConsumption->notes : '') }}</x-input.textarea>

    <div class="md:grid md:grid-cols-4 md:gap-6">
        <div class="md:col-span-1">

        </div>
        <div class="mt-5 md:col-span-3 md:mt-0">
            <table>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            <x-input.hidden name="product_id"
                                value="{{ old('product_id', $editing ? $product->id : '') }}">
                            </x-input.hidden>
                        </td>
                        <td>
                            <div class="text-xs">{{ $product->name }} </div>
                        </td>
                        <td>
                            <input
                                class="block w-full text-xs text-right border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                value="{{ $product->value ?? null }}" data-id="{{ $product->id }}"
                                name="products[{{ $product->id }}]" type="number"
                                class="product-quantity form-control">
                        </td>
                        <td>
                            <div class="ml-2 text-xs"> {{ $product->unit->unit }}</div>
                        </td>
                    </tr>
                @endforeach
            </table>

        </div>
    </div>

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $selfConsumption->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $selfConsumption->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created By</x-shows.dt>
                <x-shows.dd>{{ optional($selfConsumption->created_by)->name ?? '-' }}
                </x-shows.dd>
            </x-shows.sub-dl>
        </x-shows.dl>
    @endif
</div>
