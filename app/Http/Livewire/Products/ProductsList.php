<?php

namespace App\Http\Livewire\Products;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSimpleTablePagination;
use App\Http\Livewire\DataTables\WithSortingName;
use App\Models\FranchiseGroup;
use App\Models\MaterialGroup;
use App\Models\OnlineCategory;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\RestaurantCategory;
use App\Models\Unit;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Cviebrock\EloquentSluggable\Services\SlugService;

class ProductsList extends Component
{
    use WithSimpleTablePagination;
    use WithSortingName;
    use WithModal;
    use WithBulkAction;
    use WithCachedRows;
    use WithFilter;
    use AuthorizesRequests;

    public Product $product;
    public $productImage;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Product';

    public $sortColumn = 'products.name';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'products.name'
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

    protected $rules = [
        'productImage' => ['nullable', 'image'],
        'product.name' => ['required', 'max:255', 'string'],
        'product.slug' => ['required', 'max:255', 'string'],
        'product.sku' => ['nullable', 'max:255', 'string'],
        'product.barcode' => ['nullable', 'max:255', 'string'],
        'product.description' => ['nullable', 'max:255', 'string'],
        'product.unit_id' => ['required', 'exists:units,id'],
        'product.material_group_id' => [
            'required',
            'exists:material_groups,id',
        ],
        'product.franchise_group_id' => [
            'required',
            'exists:franchise_groups,id',
        ],
        'product.payment_type_id' => ['required', 'exists:payment_types,id'],
        'product.online_category_id' => [
            'required',
            'exists:online_categories,id',
        ],
        'product.product_group_id' => ['required', 'exists:product_groups,id'],
        'product.restaurant_category_id' => [
            'required',
            'exists:restaurant_categories,id',
        ],
        'product.remaining' => ['required'],
        'product.request' => ['required'],
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

        $this->resetProductData();
    }

    public function resetProductData()
    {
        $this->product = new Product();

        $this->productImage = null;
        $this->product->unit_id = null;
        $this->product->material_group_id = null;
        $this->product->franchise_group_id = null;
        $this->product->payment_type_id = null;
        $this->product->online_category_id = null;
        $this->product->product_group_id = null;
        $this->product->restaurant_category_id = null;
        $this->product->remaining = '1';
        $this->product->request = '1';

        $this->dispatchBrowserEvent('refresh');
    }

    public function newProduct()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.products.new_title');
        $this->resetProductData();

        $this->showModal();
    }

    public function editProduct(Product $product)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.products.edit_title');
        $this->product = $product;

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

        if (!$this->product->id) {
            $this->authorize('create', Product::class);

            $this->product->user_id = auth()->user()->id;
        } else {
            $this->authorize('update', $this->product);
        }

        if ($this->productImage) {
            $this->product->image = $this->productImage->store('public');
        }

        $this->product->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Product::class);

        collect($this->selected)->each(function (string $id) {
            $product = Product::findOrFail($id);

            if ($product->image) {
                Storage::delete($product->image);
            }

            $product->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetProductData();
    }

    // public function toggleFullSelection()
    // {
    //     if (!$this->allSelected) {
    //         $this->selected = [];
    //         return;
    //     }

    //     foreach ($this->user->products as $product) {
    //         array_push($this->selected, $product->id);
    //     }
    // }

    public function getRowsQueryProperty()
    {
        $products = Product::query();

            foreach ($this->filters as $filter => $value) {
                if (!empty($value)) {
                    $products
                        ->when($filter == 'payment_type_id', fn($products) => $products->whereRelation('paymentType', 'id', $value))
                        ->when($filter == 'product_group_id', fn($products) => $products->whereRelation('productGroup', 'id', $value))
                        ->when($filter == 'material_group_id', fn($products) => $products->whereRelation('materialGroup', 'id', $value))
                        ->when($filter == 'franchise_group_id', fn($products) => $products->whereRelation('franchiseGroup', 'id', $value))
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

    public function updatedName()
    {
        $this->slug = SlugService::createSlug(Product::class, 'slug', $this->name);
    }
}
