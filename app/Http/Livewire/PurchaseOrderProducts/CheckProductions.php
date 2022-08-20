<?php

namespace App\Http\Livewire\PurchaseOrderProducts;

use App\Models\ProductionFrom;
use App\Models\PurchaseOrderProduct;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class CheckProductions extends Component
{
    use WithPagination;

    public PurchaseOrderProduct $purchaseOrderProduct;

    public function changeStatus(PurchaseOrderProduct $purchaseOrderProduct, $status)
    {
        Validator::make(['status' => $status], [
			'status' => [
				'required',
				Rule::in(PurchaseOrderProduct::STATUS_PROCESS, PurchaseOrderProduct::STATUS_DONE, PurchaseOrderProduct::STATUS_NOT_INCLUDE),
			],
		])->validate();

		$purchaseOrderProduct->update(['status' => $status]);

		$this->dispatchBrowserEvent('updated', ['message' => "Status changed to {$status} successfully."]);
    }

    public function render()
    {
        $purchaseOrderProducts = PurchaseOrderProduct::query()->latest()->whereIn('status', ['1','2'])->paginate(20);

        // $productionFroms = ProductionFrom::query()->paginate(10);

        return view('livewire.purchase-order-products.check-productions', [
            'purchaseOrderProducts' => $purchaseOrderProducts,
            // 'productionFroms' => $productionFroms,
        ]);
    }
}
