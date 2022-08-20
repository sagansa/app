@php $editing = isset($receiptByItemLoyverse) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.date
        name="date"
        label="Date"
        value="{{ old('date', ($editing ? optional($receiptByItemLoyverse->date)->format('Y-m-d') : '')) }}"
        max="255"
        required
    ></x-input.date>

    <x-input.text
        name="receipt_number"
        label="Receipt Number"
        value="{{ old('receipt_number', ($editing ? $receiptByItemLoyverse->receipt_number : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="receipt_type"
        label="Receipt Type"
        value="{{ old('receipt_type', ($editing ? $receiptByItemLoyverse->receipt_type : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="category"
        label="Category"
        value="{{ old('category', ($editing ? $receiptByItemLoyverse->category : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="sku"
        label="SKU"
        value="{{ old('sku', ($editing ? $receiptByItemLoyverse->sku : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="item"
        label="Item"
        value="{{ old('item', ($editing ? $receiptByItemLoyverse->item : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="variant"
        label="Variant"
        value="{{ old('variant', ($editing ? $receiptByItemLoyverse->variant : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="modifiers_applied"
        label="Modifiers Applied"
        value="{{ old('modifiers_applied', ($editing ? $receiptByItemLoyverse->modifiers_applied : '')) }}"
        maxlength="255"
    ></x-input.text>

    <x-input.number
        name="quantity"
        label="Quantity"
        value="{{ old('quantity', ($editing ? $receiptByItemLoyverse->quantity : '')) }}"
        max="255"
        required
    ></x-input.number>

    <x-input.text
        name="gross_sales"
        label="Gross Sales"
        value="{{ old('gross_sales', ($editing ? $receiptByItemLoyverse->gross_sales : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="discounts"
        label="Discounts"
        value="{{ old('discounts', ($editing ? $receiptByItemLoyverse->discounts : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="net_sales"
        label="Net Sales"
        value="{{ old('net_sales', ($editing ? $receiptByItemLoyverse->net_sales : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="cost_of_goods"
        label="Cost Of Goods"
        value="{{ old('cost_of_goods', ($editing ? $receiptByItemLoyverse->cost_of_goods : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="gross_profit"
        label="Gross Profit"
        value="{{ old('gross_profit', ($editing ? $receiptByItemLoyverse->gross_profit : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="taxes"
        label="Taxes"
        value="{{ old('taxes', ($editing ? $receiptByItemLoyverse->taxes : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="dining_option"
        label="Dining Option"
        value="{{ old('dining_option', ($editing ? $receiptByItemLoyverse->dining_option : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="pos"
        label="POS"
        value="{{ old('pos', ($editing ? $receiptByItemLoyverse->pos : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="store"
        label="Store"
        value="{{ old('store', ($editing ? $receiptByItemLoyverse->store : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="cashier_name"
        label="Cashier Name"
        value="{{ old('cashier_name', ($editing ? $receiptByItemLoyverse->cashier_name : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="customer_name"
        label="Customer Name"
        value="{{ old('customer_name', ($editing ? $receiptByItemLoyverse->customer_name : '')) }}"
        maxlength="255"
    ></x-input.text>

    <x-input.text
        name="customer_contacts"
        label="Customer Contacts"
        value="{{ old('customer_contacts', ($editing ? $receiptByItemLoyverse->customer_contacts : '')) }}"
        maxlength="255"
    ></x-input.text>

    <x-input.text
        name="comment"
        label="Comment"
        value="{{ old('comment', ($editing ? $receiptByItemLoyverse->comment : '')) }}"
        maxlength="255"
    ></x-input.text>

    <x-input.text
        name="status"
        label="Status"
        value="{{ old('status', ($editing ? $receiptByItemLoyverse->status : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    @if ($editing)
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>Created Date</x-shows.dt>
            <x-shows.dd>{{ $receiptByItemLoyverse->created_at }} </x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Updated Date</x-shows.dt>
            <x-shows.dd>{{ $receiptByItemLoyverse->updated_at }} </x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager|supervisor')
        <x-shows.sub-dl>
            <x-shows.dt>Created By</x-shows.dt>
            <x-shows.dd
                >{{ optional($receiptByItemLoyverse->created_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole @role('staff|super-admin')
        <x-shows.sub-dl>
            <x-shows.dt>Updated By</x-shows.dt>
            <x-shows.dd
                >{{ optional($receiptByItemLoyverse->approved_by)->name ?? '-'
                }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
    @endif
</div>
