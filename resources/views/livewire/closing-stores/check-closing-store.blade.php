<div>

    <x-jet-button wire:click="editClosingStore({{ $closingStore->id }})">
        <i class="mr-1 icon ion-md-create"></i>@lang('crud.common.edit')
    </x-jet-button>


    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
                <x-input.currency name="cash_for_tomorrow" label="Cash for Tomorrow"
                    wire:model.defer="closingStore.cash_for_tomorrow">
                </x-input.currency>
                <x-input.currency name="cash_from_yesterday" label="Cash From Yesterday"
                    wire:model.defer="closingStore.cash_from_yesterday">
                </x-input.currency>
                <x-input.currency name="total_cash_transfer" label="Total Cash Transfer"
                    wire:model.defer="closingStore.total_cash_transfer">
                </x-input.currency>

                <x-input.select name="transfer_by_id" label="Transfer By"
                    wire:model.defer="closingStore.transfer_by_id">
                    <option value="null" disabled>-- select --</option>
                    @foreach ($users as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>

                <div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5"></div>
            </div>
            <div class="flex justify-between px-6 py-4 bg-gray-50">
                <x-buttons.secondary wire:click="$toggle('showingModal')">@lang('crud.common.cancel')</x-buttons.secondary>
                <x-jet-button wire:click="save">@lang('crud.common.save')</x-jet-button>
            </div>
        </div>
    </x-modal>
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>cash for tomorrow</x-shows.dt>
            <x-shows.dd>@currency($closingStore->cash_for_tomorrow)</x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>cash from yesterday</x-shows.dt>
            <x-shows.dd>@currency($closingStore->cash_from_yesterday)</x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Transfer By</x-shows.dt>
            <x-shows.dd>{{ $closingStore->transfer_by->name }}</x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>total cash transfer</x-shows.dt>
            <x-shows.dd>@currency($closingStore->total_cash_transfer)</x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>presence</x-shows.dt>
            <x-shows.dd>@currency($this->presence_totals)</x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>purchase order</x-shows.dt>
            <x-shows.dd>@currency($this->purchase_order_totals)</x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>fuel service</x-shows.dt>
            <x-shows.dd>@currency($this->fuel_service_totals)</x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>spending cash totals</x-shows.dt>
            <x-shows.dd>@currency($this->spending_cash_totals)</x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>non cashless omzet totals</x-shows.dt>
            <x-shows.dd>@currency($this->non_cashless_totals)</x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager')
            <x-shows.sub-dl>
                <x-shows.dt>cashless omzet totals</x-shows.dt>
                <x-shows.dd>@currency($this->cashless_totals)</x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>omzet totals</x-shows.dt>
                <x-shows.dd>@currency($this->omzet_totals)</x-shows.dd>
            </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
</div>
