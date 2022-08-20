<?php

namespace App\Http\Livewire\PurchaseOrders;

use App\Models\User;
use App\Models\Store;
use Livewire\Component;
use App\Models\Supplier;
use App\Models\PaymentType;

use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Validator;

class PurchaseOrderForm extends Component
{
    public $state = [];

    public function mount(PurchaseOrder $purchaseOrder)
    {
        $this->state = $purchaseOrder->toArray();

        $this->purchaseOrder = $purchaseOrder;
    }

    public function updatePurchaseOrder()
    {
        Validator::make(
			$this->state,
			[
				'discounts' => 'required', 'numeric',
                'taxes' => 'required', 'numeric', 'min=0',

			])->validate();

		$this->purchaseOrder->update($this->state);

		$this->dispatchBrowserEvent('alert', ['message' => 'Discounts updated successfully!']);
    }

    public function render()
    {
        $paymentTypes = PaymentType::pluck('name', 'id');
        $stores = Store::pluck('nickname', 'id');
        $suppliers = Supplier::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view('livewire.purchase-orders.purchase-order-form', [
            'paymentTypes' => $paymentTypes,
            'stores' => $stores,
            'suppliers' => $suppliers,
            'users' => $users,
        ]);
    }
}
