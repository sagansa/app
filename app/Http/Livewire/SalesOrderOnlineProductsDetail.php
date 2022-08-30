<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\SalesOrderOnline;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SalesOrderOnlineProductsDetail extends Component
{
    use AuthorizesRequests;

    public SalesOrderOnline $salesOrderOnline;
    public Product $product;
    public $productsForSelect = [];
    public $product_id = null;
    public $quantity;
    public $price;

    public $showingModal = false;
    public $modalTitle = 'New Product';

    protected $rules = [
        'product_id' => ['required', 'exists:products,id'],
        'quantity' => ['required', 'numeric', 'gt:0'],
        'price' => ['required', 'numeric', 'gt:0'],
    ];

    public function mount(SalesOrderOnline $salesOrderOnline)
    {
        $this->salesOrderOnline = $salesOrderOnline;
        $this->productsForSelect = Product::whereNotIn('online_category_id', ['4'])->orderBy('name', 'asc')->get()->pluck('id', 'product_name');
        $this->resetProductData();
    }

    public function resetProductData()
    {
        $this->product = new Product();

        $this->product_id = null;
        $this->quantity = null;
        $this->price = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newProduct()
    {
        $this->modalTitle = trans('crud.sales_order_online_products.new_title');
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

        $this->authorize('update', SalesOrderOnline::class);

        $this->salesOrderOnline->products()->attach($this->product_id, [
            'quantity' => $this->quantity,
            'price' => $this->price,
        ]);

        $this->hideModal();
    }

    public function detach($product)
    {
        $this->authorize('update', SalesOrderOnline::class);

        $this->salesOrderOnline->products()->detach($product);

        $this->resetProductData();
    }

    public function render()
    {
        return view('livewire.sales-order-online-products-detail', [
            'salesOrderOnlineProducts' => $this->salesOrderOnline
                ->products()
                ->withPivot(['quantity', 'price'])
                ->paginate(20),
        ]);
    }
}
