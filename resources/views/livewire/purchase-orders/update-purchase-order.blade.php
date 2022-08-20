<div>
    <form wire:submit.prevent="changeTaxes" autocomplete="off">
        <x-input.currency wire:model.defer="state.taxes" name="taxes" label="Taxes">
        </x-input.currency>
        <input type="number" wire:model="state.taxes" name="taxes">
    </form>
</div>
