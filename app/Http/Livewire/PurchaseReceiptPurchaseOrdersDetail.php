<?php

namespace App\Http\Livewire;

use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\PurchaseOrder;
use App\Models\PurchaseReceipt;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;

class PurchaseReceiptPurchaseOrdersDetail extends Component
{
    public $state = [];

    use AuthorizesRequests;

    public PurchaseReceipt $purchaseReceipt;
    public PurchaseOrder $purchaseOrder;
    public $purchaseOrdersForSelect = [];
    public $purchase_order_id = null;

    public $showingModal = false;
    public $modalTitle = 'New PurchaseOrder';

    protected $rules = [
        'purchase_order_id' => ['required', 'exists:purchase_orders,id'],
    ];

    public function mount(PurchaseReceipt $purchaseReceipt)
    {
        $this->state = $purchaseReceipt->toArray();

        $this->purchaseReceipt = $purchaseReceipt;
        $this->purchaseOrdersForSelect = PurchaseOrder::orderBy('date', 'desc')
            ->whereIn('payment_type_id', ['1'])
            ->whereIn('payment_status', ['1'])
            ->get()
            ->pluck('id', 'purchase_order_name');
        $this->resetPurchaseOrderData();
    }

    public function updatePurchaseReceipt()
    {
        Validator::make(
            $this->state,
            [
                'nominal_transfer' => 'required', 'numeric', 'min:0'
            ]
        )->validate();

        $this->purchaseReceipt->update($this->state);
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
            'crud.purchase_receipt_purchase_orders.new_title'
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

        $this->authorize('create', PurchaseOrder::class);

        $this->purchaseReceipt
            ->purchaseOrders()
            ->attach($this->purchase_order_id, []);

        $this->hideModal();
    }

    public function detach($purchaseOrder)
    {
        $this->authorize('delete-any', PurchaseOrder::class);

        $this->purchaseReceipt->purchaseOrders()->detach($purchaseOrder);

        $this->resetPurchaseOrderData();
    }

    public function render()
    {
        $this->subtotal = 0;
        $this->totals = 0;

        foreach ($this->purchaseReceipt->purchaseOrders as $purchaseOrder) {
            foreach ($purchaseOrder->purchaseOrderProducts as $purchaseOrderProduct) {
                $this->subtotal += $purchaseOrderProduct['subtotal_invoice'];
            }

            $this->totals = $this->subtotal - $purchaseOrder['discounts'] + $purchaseOrder['taxes'];
        }

        $this->difference = $this->purchaseReceipt->nominal_transfer - $this->totals;

        return view('livewire.purchase-receipt-purchase-orders-detail', [
            'purchaseReceiptPurchaseOrders' => $this->purchaseReceipt
                ->purchaseOrders()
                ->withPivot([])
                ->paginate(20),
        ]);
    }

    public function changePaymentStatus(PurchaseOrder $purchaseOrder, $paymentStatus)
    {
        Validator::make(['payment_status' => $paymentStatus], [
			'payment_status' => [
				'required',
				Rule::in(PurchaseOrder::STATUS_BELUM_DIBAYAR, PurchaseOrder::STATUS_SUDAH_DIBAYAR),
			],
		])->validate();

		$purchaseOrder->update(['payment_status' => $paymentStatus]);

		$this->dispatchBrowserEvent('updated', ['message' => "Status changed to {$paymentStatus} successfully."]);
    }
}
