<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Presence;
use App\Models\TransferDailySalary;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TransferDailySalaryPresencesDetail extends Component
{
    use AuthorizesRequests;

    public TransferDailySalary $transferDailySalary;
    public Presence $presence;
    public $presencesForSelect = [];
    public $presence_id = null;

    public $showingModal = false;
    public $modalTitle = 'New Presence';

    protected $rules = [
        'presence_id' => ['required', 'exists:presences,id'],
    ];

    public function mount(TransferDailySalary $transferDailySalary)
    {
        $this->transferDailySalary = $transferDailySalary;
        $this->presencesForSelect = Presence::select('*')
            ->join('users', 'users.id','=','presences.created_by_id')
            ->orderBy('users.name', 'asc')
            ->latest()
            ->where('payment_type_id', '=', '1')
            ->get()
            ->pluck('id', 'presence_name');
        $this->resetPresenceData();
    }

    public function resetPresenceData()
    {
        $this->presence = new Presence();

        $this->presence_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newPresence()
    {
        $this->modalTitle = trans(
            'crud.transfer_daily_salary_presences.new_title'
        );
        $this->resetPresenceData();

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

        $this->authorize('create', Presence::class);

        $this->transferDailySalary->presences()->attach($this->presence_id, []);

        $this->hideModal();
    }

    public function detach($presence)
    {
        $this->authorize('delete-any', Presence::class);

        $this->transferDailySalary->presences()->detach($presence);

        $this->resetPresenceData();
    }

    public function render()
    {
        return view('livewire.transfer-daily-salary-presences-detail', [
            'transferDailySalaryPresences' => $this->transferDailySalary
                ->presences()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
