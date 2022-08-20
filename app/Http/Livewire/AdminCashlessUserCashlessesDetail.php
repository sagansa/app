<?php

namespace App\Http\Livewire;

use App\Models\Store;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\UserCashless;
use App\Models\AdminCashless;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminCashlessUserCashlessesDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public AdminCashless $adminCashless;
    public UserCashless $userCashless;
    public $storesForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New UserCashless';

    protected $rules = [
        'userCashless.store_id' => ['required', 'exists:stores,id'],
        'userCashless.email' => ['nullable', 'email'],
        'userCashless.username' => ['nullable', 'max:50', 'string'],
        'userCashless.no_telp' => ['nullable', 'max:255', 'string'],
        'userCashless.password' => ['nullable'],
    ];

    public function mount(AdminCashless $adminCashless)
    {
        $this->adminCashless = $adminCashless;
        $this->storesForSelect = Store::pluck('name', 'id');
        $this->resetUserCashlessData();
    }

    public function resetUserCashlessData()
    {
        $this->userCashless = new UserCashless();

        $this->userCashless->store_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newUserCashless()
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.admin_cashless_user_cashlesses.new_title'
        );
        $this->resetUserCashlessData();

        $this->showModal();
    }

    public function editUserCashless(UserCashless $userCashless)
    {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.admin_cashless_user_cashlesses.edit_title'
        );
        $this->userCashless = $userCashless;

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

        if (!$this->userCashless->admin_cashless_id) {
            $this->authorize('create', UserCashless::class);

            $this->userCashless->admin_cashless_id = $this->adminCashless->id;
        } else {
            $this->authorize('update', $this->userCashless);
        }

        $this->userCashless->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', UserCashless::class);

        UserCashless::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetUserCashlessData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->adminCashless->userCashlesses as $userCashless) {
            array_push($this->selected, $userCashless->id);
        }
    }

    public function render()
    {
        return view('livewire.admin-cashless-user-cashlesses-detail', [
            'userCashlesses' => $this->adminCashless
                ->userCashlesses()
                ->paginate(20),
        ]);
    }
}
