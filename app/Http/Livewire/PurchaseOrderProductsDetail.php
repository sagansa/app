<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderProduct;
use App\Models\Unit;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;

class PurchaseOrderProductsDetail extends Component
{
    public $state = [];

    use WithPagination;
    use AuthorizesRequests;

    // public array $purchaseOrderProducts = [];

    public PurchaseOrder $purchaseOrder;
    public PurchaseOrderProduct $purchaseOrderProduct;
    public $productsForSelect = [];
    public $unitsForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New PurchaseOrderProduct';

    protected $rules = [
        'purchaseOrderProduct.product_id' => ['required', 'exists:products,id'],
        'purchaseOrderProduct.unit_id' => ['required', 'exists:units,id'],
        'purchaseOrderProduct.quantity_product' => ['required', 'numeric', 'min:0'],
        'purchaseOrderProduct.quantity_invoice' => ['required', 'numeric', 'min:0'],
        'purchaseOrderProduct.subtotal_invoice' => [
            'required',
            'min:0',
            'numeric',
        ],
        'purchaseOrderProduct.status' => ['required'],
    ];

    public function mount(PurchaseOrder $purchaseOrder)
    {
        $this->state = $purchaseOrder->toArray();

        $this->purchaseOrder = $purchaseOrder;
        $this->unitsForSelect = Unit::orderBy('unit', 'asc')->pluck('id', 'unit');

        if($this->purchaseOrder->payment_type_id == '2')
            $this->productsForSelect = Product::orderBy('name', 'asc')
                ->whereIn('payment_type_id', ['2'])
                ->get()
                ->pluck('id', 'product_name');
        else
            $this->productsForSelect = Product::orderBy('name', 'asc')->get()->pluck('id', 'product_name');

        $this->resetPurchaseOrderProductData();
    }

    public function updatePurchaseOrder()
    {
        Validator::make(
			$this->state,
			[
				'discounts' => 'required', 'numeric',
                'taxes' => 'required', 'numeric', 'min:0',

			])->validate();

		$this->purchaseOrder->update($this->state);
    }

    public function resetPurchaseOrderProductData()
    {
        $this->purchaseOrderProduct = new PurchaseOrderProduct();

        $this->purchaseOrderProduct->product_id = null;
        $this->purchaseOrderProduct->unit_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newPurchaseOrderProduct()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.purchase_order_products.new_title');
        $this->resetPurchaseOrderProductData();

        $this->showModal();
    }

    public function editPurchaseOrderProduct(
        PurchaseOrderProduct $purchaseOrderProduct
    ) {
        $this->editing = true;
        $this->modalTitle = trans('crud.purchase_order_products.edit_title');
        $this->purchaseOrderProduct = $purchaseOrderProduct;

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        if (!$this->purchaseOrderProduct->purchase_order_id) {
            $this->authorize('create', PurchaseOrderProduct::class);

            $this->purchaseOrderProduct->purchase_order_id =
                $this->purchaseOrder->id;

        } else {
            $this->authorize('update', $this->purchaseOrderProduct);
        }

        $this->purchaseOrderProduct->save();
        $this->emit('setProductsSelect', []);
        $this->emit($this->purchaseOrder->totals);

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', PurchaseOrderProduct::class);

        PurchaseOrderProduct::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetPurchaseOrderProductData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach (
            $this->purchaseOrder->purchaseOrderProducts
            as $purchaseOrderProduct
        ) {
            array_push($this->selected, $purchaseOrderProduct->id);
        }
    }

    public function render()
    {
        $this->purchaseOrder->subtotals = 0;

        foreach ($this->purchaseOrder->purchaseOrderProducts as $purchaseOrderProduct) {
            $this->purchaseOrder->subtotals += $purchaseOrderProduct['subtotal_invoice'];
        }

        $this->purchaseOrder->totals = $this->purchaseOrder->subtotals - $this->purchaseOrder->discounts + $this->purchaseOrder->taxes;

        return view('livewire.purchase-order-products-detail', [
            'purchaseOrderProducts' => $this->purchaseOrder
                ->purchaseOrderProducts()
                ->paginate(20),
        ]);
    }
}
