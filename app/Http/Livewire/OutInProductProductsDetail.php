<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\OutInProduct;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OutInProductProductsDetail extends Component
{
    use AuthorizesRequests;

    public OutInProduct $outInProduct;
    public Product $product;
    public $productsForSelect = [];
    public $product_id = null;
    public $quantity;

    public $showingModal = false;
    public $modalTitle = 'New Product';

    protected $rules = [
        'product_id' => ['required', 'exists:products,id'],
        'quantity' => ['required', 'numeric'],
    ];

    public function mount(OutInProduct $outInProduct)
    {
        $this->outInProduct = $outInProduct;
        $this->productsForSelect = Product::orderBy('name', 'asc')
            // ->whereIn('material_group_id', ['2'])
            ->get()
            ->pluck('id', 'product_name');
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
        $this->modalTitle = trans('crud.out_in_product_products.new_title');
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

        $this->authorize('create', OutInProduct::class);

        $this->outInProduct->products()->attach($this->product_id, [
            'quantity' => $this->quantity,
        ]);

        $this->hideModal();
    }

    public function detach($product)
    {
        // $this->authorize('delete-any', Product::class);

        $this->outInProduct->products()->detach($product);

        $this->resetProductData();
    }

    public function render()
    {
        return view('livewire.out-in-product-products-detail', [
            'outInProductProducts' => $this->outInProduct
                ->products()
                ->withPivot(['quantity'])
                ->paginate(20),
        ]);
    }
}
