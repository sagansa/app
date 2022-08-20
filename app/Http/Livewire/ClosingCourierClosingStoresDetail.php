<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ClosingStore;
use App\Models\ClosingCourier;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;

class ClosingCourierClosingStoresDetail extends Component
{
    public $state = [];

    use AuthorizesRequests;

    public ClosingCourier $closingCourier;
    public ClosingStore $closingStore;
    public $closingStoresForSelect = [];
    public $closing_store_id = null;

    public $showingModal = false;
    public $modalTitle = 'New ClosingStore';

    protected $rules = [
        'closing_store_id' => ['required', 'exists:closing_stores,id'],
    ];

    public function mount(ClosingCourier $closingCourier)
    {
        $this->state = $closingCourier->toArray();

        $this->closingCourier = $closingCourier;
        $this->closingStoresForSelect = ClosingStore::whereNotIn('transfer_by_id', ['1'])
            ->where('transfer_by_id', '=', auth()->user()->id)
            ->whereIn('status',['1'])
            ->get()
            ->pluck('closing_store_name', 'id');
        $this->resetClosingStoreData();
    }

    public function updatePurchaseReceipt()
    {
        Validator::make(
			$this->state,
			[
                'total_cash_to_transfer' => 'required', 'numeric', 'min:0',

			])->validate();

		$this->closingCourier->update($this->state);
    }

    public function resetClosingStoreData()
    {
        $this->closingStore = new ClosingStore();

        $this->closing_store_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newClosingStore()
    {
        $this->modalTitle = trans(
            'crud.closing_courier_closing_stores.new_title'
        );
        $this->resetClosingStoreData();

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

        $this->closingCourier
            ->closingStores()
            ->attach($this->closing_store_id, []);

        $this->hideModal();
    }

    public function detach($closingStore)
    {
        $this->authorize('delete-any', ClosingStore::class);

        $this->closingCourier->closingStores()->detach($closingStore);

        $this->resetClosingStoreData();
    }

    public function render()
    {
        $this->totals = 0;

        foreach ($this->closingCourier->closingStores as $closingStore) {
            $this->totals += $closingStore['total_cash_transfer'];
        }

        $this->difference = $this->closingCourier->total_cash_to_transfer - $this->totals;

        return view('livewire.closing-courier-closing-stores-detail', [
            'closingCourierClosingStores' => $this->closingCourier
                ->closingStores()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
