<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Production;
use Livewire\WithPagination;
use App\Models\ProductionTo;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductionProductionTosDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Production $production;
    public ProductionTo $productionTo;
    public $productsForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New ProductionTo';

    protected $rules = [
        'productionTo.product_id' => ['required', 'exists:products,id'],
        'productionTo.quantity' => ['required', 'numeric'],
    ];

    public function mount(Production $production)
    {
        $this->production = $production;
        $this->productsForSelect = Product::orderBy('name', 'asc')->whereIn('material_group_id', ['2'])->get()->pluck('id', 'product_name');
        $this->resetProductionToData();
    }

    public function resetProductionToData()
    {
        $this->productionTo = new ProductionTo();

        $this->productionTo->product_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newProductionTo()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.production_production_tos.new_title');
        $this->resetProductionToData();

        $this->showModal();
    }

    public function editProductionTo(ProductionTo $productionTo)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.production_production_tos.edit_title');
        $this->productionTo = $productionTo;

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

        if (!$this->productionTo->production_id) {
            $this->authorize('create', ProductionTo::class);

            $this->productionTo->production_id = $this->production->id;
        } else {
            $this->authorize('update', $this->productionTo);
        }

        $this->productionTo->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', ProductionTo::class);

        ProductionTo::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetProductionToData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->production->productionTos as $productionTo) {
            array_push($this->selected, $productionTo->id);
        }
    }

    public function render()
    {
        return view('livewire.production-production-tos-detail', [
            'productionTos' => $this->production->productionTos()->paginate(20),
        ]);
    }
}
