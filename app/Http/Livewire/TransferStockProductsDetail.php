<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\TransferStock;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TransferStockProductsDetail extends Component
{
    use AuthorizesRequests;

    public TransferStock $transferStock;
    public Product $product;
    public $productsForSelect = [];
    public $product_id = null;
    public $quantity;

    public $showingModal = false;
    public $modalTitle = 'New Product';

    protected $rules = [
        'product_id' => ['required', 'exists:products,id'],
        'quantity' => ['required', 'min:0', 'numeric'],
    ];

    public function mount(TransferStock $transferStock)
    {
        $this->transferStock = $transferStock;
        $this->productsForSelect = Product::orderBy('name', 'asc')
            ->whereIn('remaining',['1'])
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
        $this->modalTitle = trans('crud.transfer_stock_products.new_title');
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

        $this->authorize('create', TransferStock::class);

        $this->transferStock->products()->attach($this->product_id, [
            'quantity' => $this->quantity,
        ]);

        $this->hideModal();
    }

    public function detach($product)
    {
        $this->authorize('delete-any', TransferStock::class);

        $this->transferStock->products()->detach($product);

        $this->resetProductData();
    }

    public function render()
    {
        return view('livewire.transfer-stock-products-detail', [
            'transferStockProducts' => $this->transferStock
                ->products()
                ->withPivot(['quantity'])
                ->paginate(20),
        ]);
    }
}
