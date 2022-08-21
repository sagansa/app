<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Production;
use Livewire\WithPagination;
use App\Models\ProductionSupportFrom;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductionProductionSupportFromsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Production $production;
    public ProductionSupportFrom $productionSupportFrom;
    public $productsForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New ProductionSupportFrom';

    protected $rules = [
        'productionSupportFrom.product_id' => [
            'required',
            'exists:products,id',
        ],
        'productionSupportFrom.quantity' => ['required', 'numeric'],
    ];

    public function mount(Production $production)
    {
        $this->production = $production;
        $this->productsForSelect = Product::orderBy('name', 'asc')->whereIn('material_group_id', ['1'])->get()->pluck('id', 'product_name');
        $this->resetProductionSupportFromData();
    }

    public function resetProductionSupportFromData()
    {
        $this->productionSupportFrom = new ProductionSupportFrom();

        $this->productionSupportFrom->product_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newProductionSupportFrom()
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.production_production_support_froms.new_title'
        );
        $this->resetProductionSupportFromData();

        $this->showModal();
    }

    public function editProductionSupportFrom(
        ProductionSupportFrom $productionSupportFrom
    ) {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.production_production_support_froms.edit_title'
        );
        $this->productionSupportFrom = $productionSupportFrom;

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

        if (!$this->productionSupportFrom->production_id) {
            $this->authorize('create', ProductionSupportFrom::class);

            $this->productionSupportFrom->production_id = $this->production->id;
        } else {
            $this->authorize('update', $this->productionSupportFrom);
        }

        $this->productionSupportFrom->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', ProductionSupportFrom::class);

        ProductionSupportFrom::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetProductionSupportFromData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach (
            $this->production->productionSupportFroms
            as $productionSupportFrom
        ) {
            array_push($this->selected, $productionSupportFrom->id);
        }
    }

    public function render()
    {
        return view('livewire.production-production-support-froms-detail', [
            'productionSupportFroms' => $this->production
                ->productionSupportFroms()
                ->paginate(20),
        ]);
    }
}
