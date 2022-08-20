<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Presence;
use Livewire\WithPagination;
use App\Models\ClosingStore;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ClosingStorePresences extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public ClosingStore $closingStore;
    public Presence $presence;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Presence';

    protected $rules = [
        'presence.amount' => ['required', 'min:0', 'numeric'],
    ];

    public function mount(ClosingStore $closingStore)
    {
        $this->closingStore = $closingStore;
        $this->resetPresenceData();
    }

    public function resetPresenceData()
    {
        $this->presence = new Presence();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newPresence()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.closing_store_presences.new_title');
        $this->resetPresenceData();

        $this->showModal();
    }

    public function editPresence(Presence $presence)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.closing_store_presences.edit_title');
        $this->presence = $presence;

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

        if (!$this->presence->closing_store_id) {
            $this->authorize('create', Presence::class);

            $this->presence->closing_store_id = $this->closingStore->id;
        } else {
            $this->authorize('update', $this->presence);
        }

        $this->presence->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Presence::class);

        Presence::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetPresenceData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->closingStore->presences as $presence) {
            array_push($this->selected, $presence->id);
        }
    }

    public function render()
    {
        $this->subtotal = 0;
        $this->totals = 0;

        foreach ($this->closingStore->presences as $presence) {

                $this->totals += $presence['amount'];
        }

        return view('livewire.closing-store-presences', [
            'presences' => $this->closingStore->presences()->paginate(20),
        ]);
    }
}
