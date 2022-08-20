<?php

namespace App\Http\Livewire\ClosingStores;

use App\Models\ClosingStore;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CheckClosingStore extends Component
{
    public $state = [];

    public $editing = false;
    public $showingModal = false;

    public $modalTitle = 'New Closing Store';

    protected $rules = [
        'closingStore.transfer_by_id' => [
            'required',
        ],
        'closingStore.cash_for_tomorrow' => ['required', 'numeric'],
        'closingStore.cash_from_yesterday' => ['required', 'numeric'],
        'closingStore.total_cash_transfer' => ['required', 'numeric'],
    ];

    public function editClosingStore(ClosingStore $closingStore)
    {
        $this->editing = true;
        $this->modalTitle = 'Edit Closing Store';
        $this->closingStore = $closingStore;

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

        // $this->authorize('update', $this->closingStore);

        $this->closingStore->save();

        // $this->uploadIteration++;

        $this->hideModal();
    }

    public function mount(ClosingStore $closingStore)
    {

        $this->state = $closingStore->toArray();
        $this->closingStore = $closingStore;
    }

    public function updateClosingStore()
    {
        Validator::make(
			$this->state,
			[
				'cash_from_yesterday' => 'required', 'numeric', 'min=0',
                'cash_for_tomorrow' => 'required', 'numeric', 'min=0',
                'total_cash_transfer' => 'required', 'numeric', 'min=0',

			])->validate();

		$this->purchaseOrder->update($this->state);
    }
    public function render()
    {
        $users = User::orderBy('name', 'asc')->pluck('name', 'id');

        $this->presence_totals = 0;
        $this->purchase_order_subtotals = 0;
        $this->purchase_order_totals = 0;
        $this->fuel_service_totals = 0;
        $this->cashless_totals = 0;

        foreach ($this->closingStore->presences as $presence) {
            $this->presence_totals += $presence['amount'];
        }

        foreach ($this->closingStore->purchaseOrders as $purchaseOrder) {
            foreach ($purchaseOrder->purchaseOrderProducts as $purchaseOrderProduct) {
                $this->purchase_order_subtotals += $purchaseOrderProduct['subtotal_invoice'];
            }
            $this->purchase_order_totals = $this->purchase_order_subtotals - $purchaseOrder['discounts'] + $purchaseOrder['taxes'];
        }

        foreach ($this->closingStore->fuelServices as $fuelService) {
            $this->fuel_service_totals += $fuelService['amount'];
        }

        $this->spending_cash_totals = $this->presence_totals + $this->purchase_order_totals + $this->fuel_service_totals;

        $this->non_cashless_totals = $this->closingStore['cash_for_tomorrow'] - $this->closingStore['cash_from_yesterday'] + $this->spending_cash_totals + $this->closingStore['total_cash_transfer'];

        foreach ($this->closingStore->cashlesses as $cashless) {
            $this->cashless_totals += $cashless['bruto_apl'];
        }

        $this->omzet_totals = $this->non_cashless_totals + $this->cashless_totals;

        return view('livewire.closing-stores.check-closing-store', [
            'users' => $users
        ]);
    }
}
