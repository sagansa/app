<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ClosingStore;
use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ClosingStorePurchaseOrdersDetail extends Component
{
    use AuthorizesRequests;

    public ClosingStore $closingStore;
    public PurchaseOrder $purchaseOrder;
    public $purchaseOrdersForSelect = [];
    public $purchase_order_id = null;

    public $showingModal = false;
    public $modalTitle = 'New PurchaseOrder';

    protected $rules = [
        'purchase_order_id' => ['required', 'exists:purchase_orders,id'],
    ];

    public function mount(ClosingStore $closingStore)
    {
        $this->closingStore = $closingStore;
        $this->purchaseOrdersForSelect = PurchaseOrder::where('store_id', $this->closingStore->store_id)
            ->whereIn('payment_type_id', ['2'])
            ->whereIn('payment_status', ['1', '3'])
            ->get()
            ->pluck('purchase_order_name', 'id');

        $this->resetPurchaseOrderData();
    }

    public function resetPurchaseOrderData()
    {
        $this->purchaseOrder = new PurchaseOrder();

        $this->purchase_order_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newPurchaseOrder()
    {
        $this->modalTitle = trans(
            'crud.closing_store_purchase_orders.new_title'
        );
        $this->resetPurchaseOrderData();

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

        $this->authorize('create', ClosingStore::class);

        $this->closingStore
            ->purchaseOrders()
            ->attach($this->purchase_order_id, []);

        $this->hideModal();
    }

    public function detach($purchaseOrder)
    {
        // $this->authorize('delete-any', ClosingStore::class);

        if(auth()->user()->hasRole('super-admin|staff|supervisor')) {
            $this->closingStore->purchaseOrders()->detach($purchaseOrder);

            $this->resetPurchaseOrderData();
        }
    }

    public function render()
    {
        $this->subtotal = 0;
        $this->totals = 0;

        foreach ($this->closingStore->purchaseOrders as $purchaseOrder) {
            foreach ($purchaseOrder->purchaseOrderProducts as $purchaseOrderProduct) {
                $this->subtotal += $purchaseOrderProduct['subtotal_invoice'];
            }

            $this->totals = $this->subtotal - $purchaseOrder['discounts'] + $purchaseOrder['taxes'];
        }

        return view('livewire.closing-store-purchase-orders-detail', [
            'closingStorePurchaseOrders' => $this->closingStore
                ->purchaseOrders()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
