<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\UserCashless;
use App\Models\AdminCashless;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminCashlessUserCashlessesDetail extends Component
{
    use AuthorizesRequests;

    public AdminCashless $adminCashless;
    public UserCashless $userCashless;
    public $userCashlessesForSelect = [];
    public $user_cashless_id = null;

    public $showingModal = false;
    public $modalTitle = 'New UserCashless';

    protected $rules = [
        'user_cashless_id' => ['required', 'exists:user_cashlesses,id'],
    ];

    public function mount(AdminCashless $adminCashless)
    {
        $this->adminCashless = $adminCashless;
        $this->userCashlessesForSelect = UserCashless::pluck('email', 'id');
        $this->resetUserCashlessData();
    }

    public function resetUserCashlessData()
    {
        $this->userCashless = new UserCashless();

        $this->user_cashless_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newUserCashless()
    {
        $this->modalTitle = trans(
            'crud.admin_cashless_user_cashlesses.new_title'
        );
        $this->resetUserCashlessData();

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

        $this->authorize('create', UserCashless::class);

        $this->adminCashless
            ->userCashlesses()
            ->attach($this->user_cashless_id, []);

        $this->hideModal();
    }

    public function detach($userCashless)
    {
        $this->authorize('delete-any', UserCashless::class);

        $this->adminCashless->userCashlesses()->detach($userCashless);

        $this->resetUserCashlessData();
    }

    public function render()
    {
        return view('livewire.admin-cashless-user-cashlesses-detail', [
            'adminCashlessUserCashlesses' => $this->adminCashless
                ->userCashlesses()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
