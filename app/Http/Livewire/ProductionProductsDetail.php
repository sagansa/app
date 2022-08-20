<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Production;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductionProductsDetail extends Component
{
    use AuthorizesRequests;

    public Production $production;
    public Product $product;
    public $productsForSelect = [];
    public $product_id = null;
    public $quantity;

    public $showingModal = false;
    public $modalTitle = 'New Product';

    protected $rules = [
        'product_id' => ['required', 'exists:products,id'],
        'quantity' => ['required', 'numeric', 'min:0'],
    ];

    public function mount(Production $production)
    {
        $this->production = $production;
        $this->productsForSelect = Product::orderBy('name', 'asc')
            ->whereIn('material_group_id', ['1', '3'])
            ->get()
            ->pluck('product_name', 'id');
        $this->resetProductData();
    }

    public function resetProductData()
    {
        $this->product = new Product();

        $this->product_id = null;
        $this->quantity = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newProduct()
    {
        $this->modalTitle = trans('crud.production_products.new_title');
        $this->resetProductData();

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

        $this->authorize('create', Production::class);

        $this->production->products()->attach($this->product_id, [
            'quantity' => $this->quantity,
        ]);

        $this->hideModal();
    }

    public function detach($product)
    {
        // $this->authorize('update', Production::class);

        $this->production->products()->detach($product);

        $this->resetProductData();
    }

    public function render()
    {
        return view('livewire.production-products-detail', [
            'productionProducts' => $this->production
                ->products()
                ->withPivot(['quantity'])
                ->paginate(20),
        ]);
    }
}
