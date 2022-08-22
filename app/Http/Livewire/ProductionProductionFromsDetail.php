<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Production;
use Livewire\WithPagination;
use App\Models\ProductionFrom;
use App\Models\PurchaseOrderProduct;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductionProductionFromsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Production $production;
    public ProductionFrom $productionFrom;
    public $purchaseOrderProductsForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New ProductionFrom';

    protected $rules = [
        'productionFrom.purchase_order_product_id' => [
            'required',
            'exists:purchase_order_products,id',
        ],
    ];

    public function mount(Production $production)
    {
        $this->production = $production;
        // $this->purchaseOrderProductsForSelect = PurchaseOrderProduct::
        //     join('products','products.id', '=', 'purchase_order_products.product_id')
        //     ->join('material_groups', 'material_groups.id', '=', 'products.id')
        //     ->where('products.material_group_id', '=', '3')
        //     ->get()
        //     ->pluck('product_name', 'id');

        $this->purchaseOrderProductsForSelect = PurchaseOrderProduct::whereIn('status', ['1'])
            ->get()
            ->pluck('id', 'product_name');

        $this->resetProductionFromData();
    }

    public function resetProductionFromData()
    {
        $this->productionFrom = new ProductionFrom();

        $this->productionFrom->purchase_order_product_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newProductionFrom()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.production_production_froms.new_title');
        $this->resetProductionFromData();

        $this->showModal();
    }

    public function editProductionFrom(ProductionFrom $productionFrom)
    {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.production_production_froms.edit_title'
        );
        $this->productionFrom = $productionFrom;

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

        if (!$this->productionFrom->production_id) {
            $this->authorize('create', Production::class);

            $this->productionFrom->production_id = $this->production->id;

        } else {
            $this->authorize('update', $this->productionFrom);
        }

        $this->productionFrom->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Production::class);

        ProductionFrom::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetProductionFromData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->production->productionFroms as $productionFrom) {
            array_push($this->selected, $productionFrom->id);
        }
    }

    public function render()
    {
        return view('livewire.production-production-froms-detail', [
            'productionFroms' => $this->production
                ->productionFroms()
                ->paginate(20),
        ]);
    }
}
