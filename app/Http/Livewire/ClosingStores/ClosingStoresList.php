<?php

namespace App\Http\Livewire\ClosingStores;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSortingDate;
use App\Models\ClosingStore;
use App\Models\ShiftStore;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ClosingStoresList extends Component
{
    use WithPerPagePagination, WithSortingDate, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    public $sortColumn = 'closing_stores.date';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'closing_stores.date'
        ],
        'sortDirection' => [
            'except' => 'asc',
        ],
    ];

    public $filters = [
        'status' => '',
        'store_id' => null,
        'shift_store_id' => null,
    ];

    public function mount()
    {
        $this->stores = Store::orderBy('nickname', 'asc')->pluck('id', 'nickname');
        $this->shiftStores = ShiftStore::orderBy('name', 'asc')->pluck('id', 'name');
    }

    public function getRowsQueryProperty()
    {
        $closingStores = ClosingStore::query()
            ->select(['closing_stores.*', 'stores.name as storename'])
            ->join('stores', 'stores.id', '=', 'closing_stores.store_id')
            ->join('shift_stores', 'shift_stores.id', '=', 'closing_stores.shift_store_id');

            if(Auth::user()->hasRole('supervisor')) {
                foreach ($this->filters as $filter => $value) {
                    if (!empty($value)) {
                        $closingStores
                            ->when($filter == 'store_id', fn($closingStores) => $closingStores
                                ->whereRelation('store', 'id', $value)
                                ->where(function($query) {
                                    return $query
                                        ->where('approved_by_id', '=', Auth::user()->id)
                                        ->orWhereNull('approved_by_id');
                                }))

                            ->when($filter == 'status', fn($closingStores) => $closingStores
                                ->where('closing_stores.' . $filter, 'LIKE', '%' . $value . '%')
                                ->where(function($query) {
                                    return $query
                                        ->where('approved_by_id', '=', Auth::user()->id)
                                        ->orWhereNull('approved_by_id');
                                }));
                    } elseif (empty($value)) {
                        $closingStores

                            ->when($filter == 'status', fn($closingStores) => $closingStores
                                ->where('closing_stores.' . $filter, 'LIKE', '%' . $value . '%')
                                ->where(function($query) {
                                    return $query
                                        ->where('approved_by_id', '=', Auth::user()->id)
                                        ->orWhereNull('approved_by_id');
                                }));
                    }
                }
            } elseif (Auth::user()->hasRole('staff')) {

                $closingStores->where('created_by_id', '=', Auth::user()->id);

                foreach ($this->filters as $filter => $value) {
                    if (!empty($value)) {
                        $closingStores
                            ->when($filter == 'store_id', fn($closingStores) => $closingStores->whereRelation('store', 'id', $value))
                            ->when($filter == 'shift_store_id', fn($closingStores) => $closingStores->whereRelation('shiftStore', 'id', $value))
                            ->when($filter == 'status', fn($closingStores) => $closingStores->where('closing_stores.' . $filter, 'LIKE', '%' . $value . '%'));
                    }
                }
            } elseif (Auth::user()->hasRole('super-admin|manager')) {
                foreach ($this->filters as $filter => $value) {
                    if (!empty($value)) {
                        $closingStores
                            ->when($filter == 'store_id', fn($closingStores) => $closingStores->whereRelation('store', 'id', $value))
                            ->when($filter == 'shift_store_id', fn($closingStores) => $closingStores->whereRelation('shiftStore', 'id', $value))
                            ->when($filter == 'status', fn($closingStores) => $closingStores->where('closing_stores.' . $filter, 'LIKE', '%' . $value . '%'));
                    }
                }
            }

            return $this->applySorting($closingStores);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.closing-stores.closing-stores-list', [
            'closingStores' => $this->rows,
        ]);
    }

    public function markAllAsValid()
    {
        ClosingStore::whereIn('id', $this->selectedRows)->update([
            'status' => '2',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }

    public function markAllAsPeriksaUlang()
    {
        ClosingStore::whereIn('id', $this->selectedRows)->update([
            'status' => '4',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }

    public function markAllAsBelumDiperiksa()
    {
        ClosingStore::whereIn('id', $this->selectedRows)->update([
            'status' => '1',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }

    public function markAllAsPerbaiki()
    {
        ClosingStore::whereIn('id', $this->selectedRows)->update([
            'closing_status' => '3',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }
}
