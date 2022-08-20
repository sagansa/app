<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\SalesOrderEmployee;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SalesOrderEmployeeProductsDetail extends Component
{
    use AuthorizesRequests;

    public SalesOrderEmployee $salesOrderEmployee;
    public Product $product;
    public $productsForSelect = [];
    public $product_id = null;
    public $quantity;
    public $unit_price;

    public $showingModal = false;
    public $modalTitle = 'New Product';

    protected $rules = [
        'product_id' => ['required', 'exists:products,id'],
        'quantity' => ['required', 'numeric', 'min:0'],
        'unit_price' => ['required', 'numeric', 'min:0'],
    ];

    public function mount(SalesOrderEmployee $salesOrderEmployee)
    {
        $this->salesOrderEmployee = $salesOrderEmployee;
        $this->productsForSelect = Product::pluck('name', 'id');
        $this->resetProductData();
    }

    public function resetProductData()
    {
        $this->product = new Product();

        $this->product_id = null;
        $this->quantity = null;
        $this->unit_price = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newProduct()
    {
        $this->modalTitle = trans(
            'crud.sales_order_employee_products.new_title'
        );
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

        $this->authorize('create', Product::class);

        $this->salesOrderEmployee->products()->attach($this->product_id, [
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
        ]);

        $this->hideModal();
    }

    public function detach($product)
    {
        $this->authorize('delete-any', Product::class);

        $this->salesOrderEmployee->products()->detach($product);

        $this->resetProductData();
    }

    public function render()
    {
        return view('livewire.sales-order-employee-products-detail', [
            'salesOrderEmployeeProducts' => $this->salesOrderEmployee
                ->products()
                ->withPivot(['quantity', 'unit_price'])
                ->paginate(20),
        ]);
    }
}
