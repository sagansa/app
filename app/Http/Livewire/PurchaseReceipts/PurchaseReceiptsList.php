<?php

namespace App\Http\Livewire\PurchaseReceipts;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSorting;
use App\Models\PurchaseReceipt;
use Livewire\Component;

class PurchaseReceiptsList extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkAction, WithCachedRows;

    public $sortColumn = 'purchase_receipts.created_at';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'purchase_receipts.created_at'
        ],
        'sortDirection' => [
            'except' => 'asc',
        ],
    ];

    public function getRowsQueryProperty()
    {
        $purchaseReceipts = PurchaseReceipt::query();
            return $this->applySorting($purchaseReceipts);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.purchase-receipts.purchase-receipts-list', [
            'purchaseReceipts' => $this->rows,
        ]);
    }
}
