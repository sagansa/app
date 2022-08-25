<?php

namespace App\Http\Livewire\PurchaseOrderProducts;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSortingDate;
use App\Models\PurchaseOrderProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CheckProductions extends Component
{
    use WithPerPagePagination, WithSortingDate, WithModal, WithBulkAction, WithCachedRows, WithFilter;

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
    ];

    public function changeStatus(PurchaseOrderProduct $purchaseOrderProduct, $status)
    {
        Validator::make(['status' => $status], [
			'status' => [
				'required',
				Rule::in(PurchaseOrderProduct::STATUS_PROCESS, PurchaseOrderProduct::STATUS_DONE, PurchaseOrderProduct::STATUS_NO_NEED),
			],
		])->validate();

		$purchaseOrderProduct->update(['status' => $status]);

		$this->dispatchBrowserEvent('updated', ['message' => "Status changed to {$status} successfully."]);
    }

    public function getRowsQueryProperty()
    {
        $purchaseOrderProducts = PurchaseOrderProduct::query();

            if (Auth::user()->hasRole('super-admin|manager')) {
                foreach ($this->filters as $filter => $value) {
                    if (!empty($value)) {
                        $purchaseOrderProducts
                            ->when($filter == 'status', fn($purchaseOrderProducts) => $purchaseOrderProducts->where('purchase_order_products.' . $filter, 'LIKE', '%' . $value . '%'));
                    }
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
        return view('livewire.purchase-order-products.check-productions', [
            'purchaseOrderProducts' => $this->rows,
        ]);
    }
}
