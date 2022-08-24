<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\AdminCashless;
use App\Models\AccountCashless;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminCashlessAccountCashlessesDetail extends Component
{
    use AuthorizesRequests;

    public AdminCashless $adminCashless;
    public AccountCashless $accountCashless;
    public $accountCashlessesForSelect = [];
    public $account_cashless_id = null;

    public $showingModal = false;
    public $modalTitle = 'New AccountCashless';

    protected $rules = [
        'account_cashless_id' => ['required', 'exists:account_cashlesses,id'],
    ];

    public function mount(AdminCashless $adminCashless)
    {
        $this->adminCashless = $adminCashless;
        $this->accountCashlessesForSelect = AccountCashless::pluck(
            'email',
            'id'
        );
        $this->resetAccountCashlessData();
    }

    public function resetAccountCashlessData()
    {
        $this->accountCashless = new AccountCashless();

        $this->account_cashless_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newAccountCashless()
    {
        $this->modalTitle = trans(
            'crud.admin_cashless_account_cashlesses.new_title'
        );
        $this->resetAccountCashlessData();

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

        $this->authorize('create', AccountCashless::class);

        $this->adminCashless
            ->accountCashlesses()
            ->attach($this->accountCashless_id, []);

        $this->hideModal();
    }

    public function detach($accountCashless)
    {
        $this->authorize('delete-any', AccountCashless::class);

        $this->adminCashless->accountCashlesses()->detach($accountCashless);

        $this->resetAccountCashlessData();
    }

    public function render()
    {
        return view('livewire.admin-cashless-account-cashlesses-detail', [
            'adminCashlessAccountCashlesses' => $this->adminCashless
                ->accountCashlesses()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
