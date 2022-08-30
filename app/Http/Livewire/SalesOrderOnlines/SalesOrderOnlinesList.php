<?php

namespace App\Http\Livewire\SalesOrderOnlines;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSortingDate;
use App\Models\Customer;
use App\Models\DeliveryService;
use App\Models\OnlineShopProvider;
use App\Models\SalesOrderOnline;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SalesOrderOnlinesList extends Component
{

    use WithPerPagePagination, WithSortingDate, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    public SalesOrderOnline $editing;

    public $sortColumn = 'sales_order_onlines.date';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'sales_order_onlines.date'
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

    public function edit(SalesOrderOnline $salesOrderOnline)
    {
        $this->editing = $salesOrderOnline;

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
        $this->customers = Customer::orderBy('name', 'asc')->pluck('id', 'name');
        $this->stores = Store::orderBy('nickname', 'asc')->pluck('id', 'nickname');
        $this->onlineShopProviders = OnlineShopProvider::orderBy('name', 'asc')->whereIn('id', ['1', '2'])->pluck('id', 'name');
        $this->deliveryServices = DeliveryService::orderBy('name', 'asc')->pluck('id', 'name');
    }

    public function getRowsQueryProperty()
    {
        // $salesOrderOnlines = SalesOrderOnline::query()
        //     ->select(['sales_order_onlines.*', 'stores.name as storename'])
        //     ->join('stores', 'stores.id', '=', 'sales_order_onlines.store_id')
        //     ->join('customers', 'customers.id', '=', 'sales_order_onlines.customer_id')
        //     ->join('online_shop_providers', 'online_shop_providers.id', '=', 'sales_order_onlines.online_shop_provider_id')
        //     ->join('delivery_services', 'delivery_services.id', '=', 'sales_order_onlines.delivery_service_id');

        $salesOrderOnlines = SalesOrderOnline::query();

        foreach ($this->filters as $filter => $value) {
                if (!empty($value)) {
                    $salesOrderOnlines
                        ->when($filter == 'store_id', fn($salesOrderOnlines) => $salesOrderOnlines->whereRelation('store', 'id', $value))
                        ->when($filter == 'customer_id', fn($salesOrderOnlines) => $salesOrderOnlines->whereRelation('customer', 'id', $value))
                        ->when($filter == 'online_shop_provider_id', fn($salesOrderOnlines) => $salesOrderOnlines->whereRelation('onlineShopProvider', 'id', $value))
                        ->when($filter == 'delivery_service_id', fn($salesOrderOnlines) => $salesOrderOnlines->whereRelation('deliveryService', 'id', $value))
                        ->when($filter == 'status', fn($salesOrderOnlines) => $salesOrderOnlines->where('sales_order_onlines.' . $filter, 'LIKE', '%' . $value . '%'));
                }
            }

        return $this->applySorting($salesOrderOnlines);
    }

    public function render()
    {
        return view('livewire.sales-order-onlines.sales-order-onlines-list', [
            'salesOrderOnlines' => $this->rows,
        ]);
    }

    public function markAllAsBelumDikirim()
    {
        SalesOrderOnline::whereIn('id', $this->selectedRows)->update([
            'status' => '1',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }

    public function markAllAsValid()
    {
        SalesOrderOnline::whereIn('id', $this->selectedRows)->update([
            'status' => '2',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }

    public function markAllAsSudahDikirim()
    {
        SalesOrderOnline::whereIn('id', $this->selectedRows)->update([
            'status' => '3',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }

    public function markAllAsDikembalikan()
    {
        SalesOrderOnline::whereIn('id', $this->selectedRows)->update([
            'status' => '4',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }
}
