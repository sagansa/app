<?php

namespace App\Http\Livewire\PurchaseOrders;

use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class UpdatePurchaseOrder extends Component
{
    public $state = [];

    public $purchaseOrder;

    public function mount(PurchaseOrder $purchaseOrder)
    {
        $this->state = $purchaseOrder->toArray();

        $this->purchaseOrder = $purchaseOrder;
    }

    public function changeTaxes()
    {
        Validator::make(
            $this->state,
            [
                'taxes' => 'required',
            ])->validate();

        $this->purchaseOrder->update($this->state);

        $this->dispatchBrowserEvent('updated', ['message' => "Taxes changed successfully."]);
    }

    public function changeDiscounts(PurchaseOrder $purchaseOrder, $discounts)
    {
        Validator::make(['discounts' => $discounts], [
            'discounts' => [
                'required', 'numeric'
            ]
        ])->validate();

        $purchaseOrder->update(['discounts' => $discounts]);

        $this->dispatchBrowserEvent('updated', ['message' => "Discounts changed to {$discounts} successfully."]);
    }

    public function render()
    {
        return view('livewire.purchase-orders.update-purchase-order');
    }
}
