@php $editing = isset($receiptLoyverse) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.date
        name="date"
        label="Date"
        value="{{ old('date', ($editing ? optional($receiptLoyverse->date)->format('Y-m-d') : '')) }}"
        max="255"
        required
    ></x-input.date>

    <x-input.text
        name="receipt_number"
        label="Receipt Number"
        value="{{ old('receipt_number', ($editing ? $receiptLoyverse->receipt_number : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="receipt_type"
        label="Receipt Type"
        value="{{ old('receipt_type', ($editing ? $receiptLoyverse->receipt_type : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="gross_sales"
        label="Gross Sales"
        value="{{ old('gross_sales', ($editing ? $receiptLoyverse->gross_sales : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="discounts"
        label="Discounts"
        value="{{ old('discounts', ($editing ? $receiptLoyverse->discounts : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="net_sales"
        label="Net Sales"
        value="{{ old('net_sales', ($editing ? $receiptLoyverse->net_sales : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="taxes"
        label="Taxes"
        value="{{ old('taxes', ($editing ? $receiptLoyverse->taxes : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="total_collected"
        label="Total Collected"
        value="{{ old('total_collected', ($editing ? $receiptLoyverse->total_collected : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="cost_of_goods"
        label="Cost Of Goods"
        value="{{ old('cost_of_goods', ($editing ? $receiptLoyverse->cost_of_goods : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="gross_profit"
        label="Gross Profit"
        value="{{ old('gross_profit', ($editing ? $receiptLoyverse->gross_profit : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="payment_type"
        label="Payment Type"
        value="{{ old('payment_type', ($editing ? $receiptLoyverse->payment_type : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.textarea
        name="description"
        label="Description"
        maxlength="255"
        required
        >{{ old('description', ($editing ? $receiptLoyverse->description : ''))
        }}</x-input.textarea
    >

    <x-input.text
        name="dining_option"
        label="Dining Option"
        value="{{ old('dining_option', ($editing ? $receiptLoyverse->dining_option : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="pos"
        label="Pos"
        value="{{ old('pos', ($editing ? $receiptLoyverse->pos : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="store"
        label="Store"
        value="{{ old('store', ($editing ? $receiptLoyverse->store : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="cashier_name"
        label="Cashier Name"
        value="{{ old('cashier_name', ($editing ? $receiptLoyverse->cashier_name : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="customer_name"
        label="Customer Name"
        value="{{ old('customer_name', ($editing ? $receiptLoyverse->customer_name : '')) }}"
        maxlength="255"
    ></x-input.text>

    <x-input.text
        name="customer_contacts"
        label="Customer Contacts"
        value="{{ old('customer_contacts', ($editing ? $receiptLoyverse->customer_contacts : '')) }}"
        maxlength="255"
    ></x-input.text>

    @if($editing)

    <x-input.text
        name="status"
        label="Status"
        value="{{ old('status', ($editing ? $receiptLoyverse->status : '')) }}"
        maxlength="255"
        required
    ></x-input.text>
    @endif @if ($editing)
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>Created Date</x-shows.dt>
            <x-shows.dd>{{ $receiptLoyverse->created_at }} </x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Updated Date</x-shows.dt>
            <x-shows.dd>{{ $receiptLoyverse->updated_at }} </x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager|supervisor')
        <x-shows.sub-dl>
            <x-shows.dt>Created By</x-shows.dt>
            <x-shows.dd
                >{{ optional($receiptLoyverse->created_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole @role('staff|super-admin')
        <x-shows.sub-dl>
            <x-shows.dt>Updated By</x-shows.dt>
            <x-shows.dd
                >{{ optional($receiptLoyverse->approved_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
    @endif
</div>
