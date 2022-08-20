@php $editing = isset($requestStock) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.select name="store_id" label="Store" required>
        @php $selected = old('store_id', ($editing ? $requestStock->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($stores as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="status" label="Status">
        @php $selected = old('status', ($editing ? $requestStock->status : '1')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >diajukan</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >selesai</option>
        <option value="3" {{ $selected == '3' ? 'selected' : '' }} >diorder</option>
        <option value="4" {{ $selected == '4' ? 'selected' : '' }} >dikirim</option>
    </x-input.select>

    <x-input.textarea name="notes" label="Notes"
        >{{ old('notes', ($editing ? $requestStock->notes : ''))
        }}</x-input.textarea
    >

    <div class="px-4 my-4">
        <h4 class="font-bold text-lg text-gray-700">
            Assign @lang('crud.products.name')
        </h4>

        <div class="py-2">
            @foreach ($products as $product)
            <div>
                <x-inputs.checkbox
                    id="product{{ $product->id }}"
                    name="products[]"
                    label="{{ ucfirst($product->name) }}"
                    value="{{ $product->id }}"
                    :checked="isset($requestStock) ? $requestStock->products()->where('id', $product->id)->exists() : false"
                    :add-hidden-value="false"
                ></x-inputs.checkbox>
            </div>
            @endforeach
        </div>
    </div>

    @if ($editing)
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>Created Date</x-shows.dt>
            <x-shows.dd>{{ $requestStock->created_at }} </x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Updated Date</x-shows.dt>
            <x-shows.dd>{{ $requestStock->updated_at }} </x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager|supervisor')
        <x-shows.sub-dl>
            <x-shows.dt>Created By</x-shows.dt>
            <x-shows.dd
                >{{ optional($requestStock->created_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole @role('staff|super-admin')
        <x-shows.sub-dl>
            <x-shows.dt>Updated By</x-shows.dt>
            <x-shows.dd
                >{{ optional($requestStock->approved_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
    @endif
</div>
