<?php

namespace App\Http\Livewire\UserCashlesses;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSorting;
use App\Models\CashlessProvider;
use App\Models\Store;
use App\Models\StoreCashless;
use App\Models\UserCashless;
use Livewire\Component;
use Livewire\WithPagination;

class UserCashlessesList extends Component
{
    use WithPagination;
    use WithPerPagePagination;
    use WithSorting;
    use WithModal;
    use WithBulkAction;
    use WithCachedRows;
    use WithFilter;

    public UserCashless $editing;

    public $sortColumn = 'user_cashlesses.created_at';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'user_cashlesses.created_at'
        ],
        'sortDirection' => [
            'except' => 'desc',
        ],
    ];

    public $filters = [
        'store_id' => null,
        'cashless_provider_id' => null,
        'store_cashless_id' => null,
    ];

    public function mount()
    {
        $this->stores = Store::orderBy('nickname', 'asc')->pluck('id', 'nickname');
        $this->cashlessProviders = CashlessProvider::orderBy('name', 'asc')->pluck('id', 'name');
        $this->storeCashlesses = StoreCashless::pluck('id', 'name');
    }

    public function getRowsQueryProperty()
    {
        $userCashlesses = UserCashless::query()
            ->select(['user_cashlesses.*', 'stores.name as storename'])
            ->join('stores', 'stores.id', '=', 'user_cashlesses.store_id')
            ->join('cashless_providers', 'cashless_providers.id', '=', 'user_cashlesses.cashless_provider_id')
            ->join('store_cashlesses', 'store_cashlesses.id', '=', 'user_cashlesses.store_cashless_id');

        foreach($this->filters as $filter => $value) {
            if (!empty($value)) {
                $userCashlesses
                    ->when($filter == 'store_id', fn($userCashlesses) => $userCashlesses->whereRelation('store', 'id', $value))
                    ->when($filter == 'cashless_provider_id', fn($userCashlesses) => $userCashlesses->whereRelation('cashlessProvider', 'id', $value))
                    ->when($filter == 'store_cashless_id', fn($userCashlesses) => $userCashlesses->whereRelation('storeCashless', 'id', $value));
            }
        }

        return $this->applySorting($userCashlesses);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        // $userCashlesses = UserCashless::get();
        dd($this->rows);
        return view('livewire.user-cashlesses.user-cashlesses-list', [
            'userCashlesses' => $this->rows,
        ]);
    }

    // public function render()
    // {
    //     $userCashlesses = UserCashless::query()
    //         ->select('*')
    //         ->join('stores', 'stores.id', '=', 'user_cashlesses.store_id')
    //         ->join('cashless_providers', 'cashless_providers.id', '=', 'user_cashlesses.cashless_provider_id')
    //         ->join('store_cashlesses', 'store_cashlesses.id', '=', 'user_cashlesses.store_cashless_id');

    //     foreach($this->filters as $filter => $value) {
    //         if (!empty($value)) {
    //             $userCashlesses
    //                 ->when($filter == 'store_id', fn($userCashlesses) => $userCashlesses->whereRelation('store', 'id', $value))
    //                 ->when($filter == 'cashless_provider_id', fn($userCashlesses) => $userCashlesses->whereRelation('cashlessProvider', 'id', $value))
    //                 ->when($filter == 'store_cashless_id', fn($userCashlesses) => $userCashlesses->whereRelation('storeCashless', 'id', $value));
    //         }
    //     }

    //     return view('livewire.user-cashlesses.user-cashlesses-list', [
    //         'userCashlesses' => $userCashlesses->paginate(20),
    //     ]);
    // }
}
