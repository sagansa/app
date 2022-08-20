<?php

namespace App\Http\Livewire\PurchaseReceipts;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderProduct;
use App\Models\PurchaseReceipt;
use Livewire\Component;
use Livewire\WithPagination;

class PurchaseReceiptsList extends Component
{
    use WithPagination;

    public function mount(PurchaseReceipt $purchaseReceipt)
    {
        $this->purchaseReceipt = $purchaseReceipt;
    }

    public function render()
    {
        $purchaseReceipts = PurchaseReceipt::latest()->get();

        return view('livewire.purchase-receipts.purchase-receipts-list', [
            'purchaseReceipts' => $purchaseReceipts
                // ->paginate(20),
        ]);
    }
}
