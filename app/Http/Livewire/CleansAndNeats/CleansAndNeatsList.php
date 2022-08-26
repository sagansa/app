<?php

namespace App\Http\Livewire\CleansAndNeats;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSorting;
use App\Models\CleanAndNeat;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CleansAndNeatsList extends Component
{
    use WithPerPagePagination, WithSorting, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    public CleanAndNeat $editing;

    public $sortColumn = 'cleans_and_neats.created_at';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'cleans_and_neats.created_at'
        ],
        'sortDirection' => [
            'except' => 'desc',
        ],
    ];

    public $filters = [
        'created_by_id' => null,
        'status' => '',
        'username' => '',
    ];

    public function mount()
    {
        $this->users = User::orderBy('name', 'asc')->pluck('id', 'name');
    }

    public function getRowsQueryProperty()
    {
        $cleansAndNeats = CleanAndNeat::query()
            ->select(['cleans_and_neats.*', 'users.name as username'])
            ->join('users', 'users.id', '=', 'cleans_and_neats.created_by_id');

        foreach ($this->filters as $filter => $value) {
            if (!empty($value)) {
                $cleansAndNeats
                    ->when($filter == 'bank_id', fn($cleansAndNeats) => $cleansAndNeats->whereRelation('bank', 'id', $value))
                    ->when($filter == 'status', fn($cleansAndNeats) => $cleansAndNeats->where('closing_couriers.' . $filter, 'LIKE', '%' . $value . '%'));
            }
        }

        return $this->applySorting($cleansAndNeats);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.cleans-and-neats.cleans-and-neats-list', [
            'cleansAndNeats' => $this->rows,
        ]);
    }
}
