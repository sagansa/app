<?php

namespace App\Http\Livewire\Products;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSortingDate;
use App\Models\PurchaseOrderProduct;
use Livewire\Component;

class CheckUnitPricePurchase extends Component
{
    use WithPerPagePagination, WithSortingDate, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    public PurchaseOrderProduct $editing;

    public $sortColumn = 'purchase_order_products.product_id';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'purchase_order_products.product_id'
        ],
        'sortDirection' => [
            'except' => 'desc',
        ],
    ];

    public $filters = [
        'storename' => '',
        'payment_status' => '',
        'order_status' => '',
        'store_id' => null,
        'supplier_id' => null,
        'payment_type_id' => null,
    ];

    public function mount()
    {

    }

    public function getRowsQueryProperty()
    {
        $purchaseOrderProducts = PurchaseOrderProduct::query();

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
        return view('livewire.products.check-unit-price-purchase', [
            'purchaseOrderProducts' => $this->rows,
        ]);
    }
}
