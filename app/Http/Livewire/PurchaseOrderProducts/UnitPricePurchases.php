<?php

namespace App\Http\Livewire\PurchaseOrderProducts;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithSimpleTablePagination;
use App\Http\Livewire\DataTables\WithSorting;
use App\Models\Product;
use App\Models\PurchaseOrderProduct;
use App\Models\Store;
use App\Models\Supplier;
use Livewire\Component;

class UnitPricePurchases extends Component
{
    use WithSimpleTablePagination, WithSorting, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    public PurchaseOrderProduct $editing;

    public $sortColumn = 'purchase_order_products.created_at';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'purchase_order_products.date'
        ],
        'sortDirection' => [
            'except' => 'asc',
        ],
    ];

    public $filters = [
        'status' => '',
        'store_id' => null,
        'supplier_id' => null,
        'product_id' => null,
    ];

    public function mount()
    {
        $this->suppliers = Supplier::orderBy('name', 'asc')->pluck('id', 'name');
        $this->stores = Store::orderBy('nickname', 'asc')->pluck('id', 'nickname');
        $this->products = Product::orderBy('name', 'asc')->pluck('id', 'name');
    }

    public function getRowsQueryProperty()
    {
        $purchaseOrderProducts = PurchaseOrderProduct::query();

            foreach ($this->filters as $filter => $value) {
                if (!empty($value)) {
                    $purchaseOrderProducts
                        // ->when($filter == 'store_id', fn($purchaseOrderProducts) => $purchaseOrderProducts->whereRelation('store', 'id', $value))
                        // ->when($filter == 'supplier_id', fn($purchaseOrderProducts) => $purchaseOrderProducts->whereRelation('supplier', 'id', $value))
                        ->when($filter == 'product_id', fn($purchaseOrderProducts) => $purchaseOrderProducts->whereRelation('product', 'id', $value));
                }
            }

        return $this->applySorting($purchaseOrderProducts);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.purchase-order-products.unit-price-purchases', [
            'purchaseOrderProducts' => $this->rows,
        ]);
    }
}
