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
        'storename' => '',
        'payment_status' => '',
        'order_status' => '',
        'store_id' => null,
        'supplier_id' => null,
        'payment_type_id' => null,
    ];

    public function rules()
    {
        return [
            'editing.notes' => 'nullable',
            'editing.status' => 'required|in:1,2,3,4',
        ];
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        $this->editing = $purchaseOrder;

        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();

        $this->editing['approved_by_id'] = Auth::user()->id;

        $this->editing->save();

        $this->showEditModal = false;
    }

    public function mount()
    {
        $this->suppliers = Supplier::orderBy('name', 'asc')->pluck('id', 'name');
        $this->stores = Store::orderBy('nickname', 'asc')->pluck('id', 'nickname');
        $this->paymentTypes = PaymentType::orderBy('name', 'asc')->whereIn('id', ['1', '2'])->pluck('id', 'name');
    }

    public function getRowsQueryProperty()
    {
        $purchaseOrders = PurchaseOrder::query()
            ->select(['purchase_orders.*', 'stores.name as storename'])
            ->join('stores', 'stores.id', '=', 'purchase_orders.store_id')
            ->join('payment_types', 'payment_types.id', '=', 'purchase_orders.payment_type_id')
            ->join('suppliers', 'suppliers.id', '=', 'purchase_orders.supplier_id');

        if (Auth::user()->hasRole('staff|supervisor')) {

                $purchaseOrders->where('created_by_id', '=', Auth::user()->id);

                foreach ($this->filters as $filter => $value) {
                    if (!empty($value)) {
                        $purchaseOrders
                            ->when($filter == 'store_id', fn($purchaseOrders) => $purchaseOrders->whereRelation('store', 'id', $value))
                            ->when($filter == 'supplier_id', fn($purchaseOrders) => $purchaseOrders->whereRelation('supplier', 'id', $value))
                            ->when($filter == 'payment_type_id', fn($purchaseOrders) => $purchaseOrders->whereRelation('paymentType', 'id', $value))
                            ->when($filter == 'payment_status', fn($purchaseOrders) => $purchaseOrders->where('purchase_orders.' . $filter, 'LIKE', '%' . $value . '%'))
                            ->when($filter == 'order_status', fn($purchaseOrders) => $purchaseOrders->where('purchase_orders.' . $filter, 'LIKE', '%' . $value . '%'));
                    }
                }
            } elseif(Auth::user()->hasRole('super-admin|manager')) {
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
        }

        $purchaseOrders->withSum('purchaseOrderProducts', 'subtotal_invoice')->get();

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
