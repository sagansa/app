<?php

namespace App\Http\Livewire\PurchaseOrders;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSortingDate;
use App\Models\PaymentType;
use App\Models\PurchaseOrder;
use App\Models\Store;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PurchaseOrdersList extends Component
{
    use WithPerPagePagination, WithSortingDate, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    public PurchaseOrder $editing;

    public $sortColumn = 'purchase_orders.date';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'purchase_orders.date'
        ],
        'sortDirection' => [
            'except' => 'desc',
        ],
    ];

    public $filters = [
        'payment_status' => '',
        'order_status' => '',
        'store_id' => null,
        'supplier_id' => null,
        'payment_type_id' => null,
    ];

    public function mount()
    {
        $this->suppliers = Supplier::orderBy('name', 'asc')->pluck('id', 'name');
        $this->stores = Store::orderBy('nickname', 'asc')->pluck('id', 'nickname');
        $this->paymentTypes = PaymentType::orderBy('name', 'asc')->whereIn('id', ['1', '2'])->pluck('id', 'name');
    }

    public function getRowsQueryProperty()
    {
        $purchaseOrders = PurchaseOrder::query()
            ->select('*')
            ->join('stores', 'stores.id', '=', 'purchase_orders.store_id')
            ->join('payment_types', 'payment_types.id', '=', 'purchase_orders.payment_type_id')
            ->join('suppliers', 'suppliers.id', '=', 'purchase_orders.supplier_id');

        foreach ($this->filters as $filter => $value) {
            if (!empty($value)) {
                $purchaseOrders
                    ->when($filter == 'store_id', fn($purchaseOrders) => $purchaseOrders->whereRelation('store', 'id', $value))
                    ->when($filter == 'supplier_id', fn($purchaseOrders) => $purchaseOrders->whereRelation('supplier', 'id', $value))
                    ->when($filter == 'payment_status', fn($purchaseOrders) => $purchaseOrders->where('purchase_orders.' . $filter, 'LIKE', '%' . $value . '%'))
                    ->when($filter == 'payment_type_id', fn($purchaseOrders) => $purchaseOrders->whereRelation('paymentType', 'id', $value))
                    ->when($filter == 'order_status', fn($purchaseOrders) => $purchaseOrders->where('purchase_orders.' . $filter, 'LIKE', '%' . $value . '%'));
            }
        }

        foreach ($purchaseOrders as $purchaseOrder) {
            $purchaseOrder->totals = 0;
            foreach ($purchaseOrder->purchaseOrderProducts as $purchaseOrderProduct) {
                $purchaseOrder->totals += $purchaseOrderProduct->subtotal_invoice;
            }
        }

        return $this->applySorting($purchaseOrders);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.purchase-orders.purchase-orders-list', [
            'purchaseOrders' => $this->rows,
        ]);
    }

    public function markAllAsSudahDibayar()
    {
        PurchaseOrder::whereIn('id', $this->selectedRows)->update([
            'payment_status' => '2',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }

    public function markAllAsBelumDibayar()
    {
        PurchaseOrder::whereIn('id', $this->selectedRows)->update([
            'payment_status' => '1',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }

    public function markAllAsTidakValid()
    {
        PurchaseOrder::whereIn('id', $this->selectedRows)->update([
            'payment_status' => '3',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }
}
