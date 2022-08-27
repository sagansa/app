<?php

namespace App\Http\Livewire\Products;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSimpleTablePagination;
use App\Http\Livewire\DataTables\WithSorting;
use App\Models\FranchiseGroup;
use App\Models\MaterialGroup;
use App\Models\OnlineCategory;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\RestaurantCategory;
use App\Models\Unit;
use Livewire\Component;

class ProductsList extends Component
{
    use WithSimpleTablePagination, WithSorting, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    public Product $editing;

    public $sortColumn = 'products.created_at';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'products.created_at'
        ],
        'sortDirection' => [
            'except' => 'desc',
        ],
    ];

    public $filters = [
        'request' => '',
        'remaining' => '',
        'storename' => '',
        'payment_type_id' => null,
        'product_group_id' => null,
        'material_group_id' => null,
        'franchise_group_id' => null,
        'online_category_id' => null,
        'restaurant_category_id' => null,
        'unit_id' => null,
    ];

    public function mount()
    {
        $this->units = Unit::orderBy('unit', 'asc')->pluck('id', 'unit');

        $this->paymentTypes = PaymentType::orderBy('name', 'asc')->pluck('id', 'name');
        $this->productGroups = ProductGroup::orderBy('name', 'asc')->pluck('id', 'name');
        $this->materialGroups = MaterialGroup::orderBy('name', 'asc')->pluck('id', 'name');
        $this->franchiseGroups = FranchiseGroup::orderBy('name', 'asc')->pluck('id', 'name');
        $this->onlineCategories = OnlineCategory::orderBy('name', 'asc')->pluck('id', 'name');
        $this->restaurantCategories = RestaurantCategory::orderBy('name', 'asc')->pluck('id', 'name');
    }

    public function getRowsQueryProperty()
    {
        $products = Product::query();

            foreach ($this->filters as $filter => $value) {
                if (!empty($value)) {
                    $products
                        ->when($filter == 'payment_type_id', fn($products) => $products->whereRelation('paymentType', 'id', $value))
                        ->when($filter == 'product_group_id', fn($products) => $products->whereRelation('productGroup', 'id', $value))
                        ->when($filter == 'material_group_id', fn($products) => $products->whereRelation('materialGroup', 'id', $value))
                        ->when($filter == 'franchsie_group_id', fn($products) => $products->whereRelation('franchiseGroup', 'id', $value))
                        ->when($filter == 'online_category_id', fn($products) => $products->whereRelation('onlineCategory', 'id', $value))
                        ->when($filter == 'restaurant_category_id', fn($products) => $products->whereRelation('restaurantCategory', 'id', $value))
                        ->when($filter == 'remaining', fn($purchaseOrders) => $purchaseOrders->where('products.' . $filter, 'LIKE', '%' . $value . '%'))
                        ->when($filter == 'request', fn($purchaseOrders) => $purchaseOrders->where('products.' . $filter, 'LIKE', '%' . $value . '%'));
                }
            }

        return $this->applySorting($products);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.products.products-list', [
            'products' => $this->rows,
        ]);
    }
}
