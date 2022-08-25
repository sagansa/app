<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Store;
use Livewire\Component;
use App\Models\Supplier;
use App\Models\PaymentType;
use Livewire\WithPagination;
use App\Models\PurchaseOrder;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StorePurchaseOrdersDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public Store $store;
    public PurchaseOrder $purchaseOrder;
    public $paymentTypesForSelect = [];
    public $suppliersForSelect = [];
    public $usersForSelect = [];
    public $purchaseOrderImage;
    public $uploadIteration = 0;
    public $purchaseOrderDate;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New PurchaseOrder';

    protected $rules = [
        'purchaseOrderImage' => ['nullable', 'image', 'max:1024'],
        'purchaseOrder.payment_type_id' => [
            'required',
            'exists:payment_types,id',
        ],
        'purchaseOrder.supplier_id' => ['required', 'exists:suppliers,id'],
        'purchaseOrderDate' => ['required', 'date'],
        'purchaseOrder.taxes' => ['required', 'max:255'],
        'purchaseOrder.discounts' => ['required', 'max:255'],
        'purchaseOrder.payment_status' => ['required', 'max:255'],
        'purchaseOrder.order_status' => ['required', 'max:255'],
        'purchaseOrder.notes' => ['nullable', 'max:255', 'string'],
        'purchaseOrder.created_by_id' => ['nullable', 'exists:users,id'],
        'purchaseOrder.approved_by_id' => ['nullable', 'exists:users,id'],
    ];

    public function mount(Store $store)
    {
        $this->store = $store;
        $this->paymentTypesForSelect = PaymentType::pluck('name', 'id');
        $this->suppliersForSelect = Supplier::pluck('name', 'id');
        $this->usersForSelect = User::pluck('name', 'id');
        $this->resetPurchaseOrderData();
    }

    public function resetPurchaseOrderData()
    {
        $this->purchaseOrder = new PurchaseOrder();

        $this->purchaseOrderImage = null;
        $this->purchaseOrderDate = null;
        $this->purchaseOrder->payment_type_id = null;
        $this->purchaseOrder->supplier_id = null;
        $this->purchaseOrder->payment_status = null;
        $this->purchaseOrder->order_status = null;
        $this->purchaseOrder->created_by_id = null;
        $this->purchaseOrder->approved_by_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newPurchaseOrder()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.store_purchase_orders.new_title');
        $this->resetPurchaseOrderData();

        $this->showModal();
    }

    public function editPurchaseOrder(PurchaseOrder $purchaseOrder)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.store_purchase_orders.edit_title');
        $this->purchaseOrder = $purchaseOrder;

        $this->purchaseOrderDate = $this->purchaseOrder->date->format('Y-m-d');

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

        if (!$this->purchaseOrder->store_id) {
            $this->authorize('create', PurchaseOrder::class);

            $this->purchaseOrder->store_id = $this->store->id;
        } else {
            $this->authorize('update', $this->purchaseOrder);
        }

        if ($this->purchaseOrderImage) {
            $this->purchaseOrder->image = $this->purchaseOrderImage->store(
                'public'
            );
        }

        $this->purchaseOrder->date = \Carbon\Carbon::parse(
            $this->purchaseOrderDate
        );

        $this->purchaseOrder->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', PurchaseOrder::class);

        collect($this->selected)->each(function (string $id) {
            $purchaseOrder = PurchaseOrder::findOrFail($id);

            if ($purchaseOrder->image) {
                Storage::delete($purchaseOrder->image);
            }

            $purchaseOrder->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetPurchaseOrderData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->store->purchaseOrders as $purchaseOrder) {
            array_push($this->selected, $purchaseOrder->id);
        }
    }

    public function render()
    {
        return view('livewire.store-purchase-orders-detail', [
            'purchaseOrders' => $this->store->purchaseOrders()->paginate(20),
        ]);
    }
}
