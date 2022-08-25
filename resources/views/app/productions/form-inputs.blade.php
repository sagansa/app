@php $editing = isset($production) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">

    @role('staff|super-admin|manager')
        <x-input.select name="store_id" label="Store" required>
            @php $selected = old('store_id', ($editing ? $production->store_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            @foreach ($stores as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-input.select>

        <x-input.date name="date" label="Date"
            value="{{ old('date', $editing ? optional($production->date)->format('Y-m-d') : '') }}" required>
        </x-input.date>

        <x-input.hidden name="status" value="{{ old('status', $editing ? $production->status : '1') }}">
        </x-input.hidden>
    @endrole

    @role('supervisor')
        <x-input.hidden name="store_id" value="{{ old('store_id', $editing ? $production->store_id : '') }}">
        </x-input.hidden>

        <x-input.hidden name="date"
            value="{{ old('date', $editing ? optional($production->date)->format('Y-m-d') : '') }}">
        </x-input.hidden>

        <x-input.hidden name="product_id" value="{{ old('product_id', $editing ? $production->product_id : '') }}">
        </x-input.hidden>

        <x-input.hidden name="quantity" label="Quantity"
            value="{{ old('quantity', $editing ? $production->quantity : '') }}" required></x-input.hidden>
    @endrole

    @if ($editing)
        @role('manager|supervisor|super-admin')
            <x-input.select name="status" label="Status">
                @php $selected = old('status', ($editing ? $production->status : '1')) @endphp
                <option disabled value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diperiksa</option>
                <option value="2" {{ $selected == '2' ? 'selected' : '' }}>valid</option>
                <option value="3" {{ $selected == '3' ? 'selected' : '' }}>perbaiki</option>
                <option disabled value="4" {{ $selected == '4' ? 'selected' : '' }}>periksa ulang</option>
            </x-input.select>
        @endrole

        @role('staff')
            @if ($production->approved_by_id != null)
                <x-input.select name="status" label="Status">
                    @php $selected = old('status', ($editing ? $production->status : '1')) @endphp
                    <option disabled value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diperiksa</option>
                    <option disabled value="3" {{ $selected == '3' ? 'selected' : '' }}>perbaiki</option>
                    <option value="4" {{ $selected == '4' ? 'selected' : '' }}>periksa ulang</option>
                </x-input.select>
            @else
                <x-input.hidden name="status" value="{{ old('status', $editing ? $production->status : '1') }}">
                </x-input.hidden>
            @endif
        @endrole
    @endif

    @if (!$editing)
        <x-input.hidden name="status" value="{{ old('status', $editing ? $production->status : '1') }}">
        </x-input.hidden>
    @endif

    <x-input.textarea name="notes" label="Notes">{{ old('notes', $editing ? $production->notes : '') }}
    </x-input.textarea>

    @if ($editing)
        <x-shows.dl>
            @role('manager|supervisor')
                <x-shows.sub-dl>
                    <x-shows.dt>Store</x-shows.dt>
                    <x-shows.dd>{{ $production->store->nickname }} </x-shows.dd>
                </x-shows.sub-dl>
                <x-shows.sub-dl>
                    <x-shows.dt>Date</x-shows.dt>
                    <x-shows.dd>{{ $production->date->toFormattedDate() }} </x-shows.dd>
                </x-shows.sub-dl>
                <x-shows.sub-dl>
                    <x-shows.dt>Product</x-shows.dt>
                    <x-shows.dd>{{ $production->product->name }} </x-shows.dd>
                </x-shows.sub-dl>
                <x-shows.sub-dl>
                    <x-shows.dt>Quantity</x-shows.dt>
                    <x-shows.dd>{{ $production->quantity }} {{ $production->product->unit->unit }} </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $production->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $production->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>

            @role('super-admin|manager|supervisor')
                <x-shows.sub-dl>
                    <x-shows.dt>Created By</x-shows.dt>
                    <x-shows.dd>{{ optional($production->created_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
            @role('manager|staff|super-admin')
                <x-shows.sub-dl>
                    <x-shows.dt>Approved By</x-shows.dt>
                    <x-shows.dd>{{ optional($production->approved_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
        </x-shows.dl>
    @endif
</div>
