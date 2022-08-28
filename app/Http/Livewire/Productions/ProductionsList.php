<?php

namespace App\Http\Livewire\Productions;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSortingDate;
use App\Models\Production;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductionsList extends Component
{

    use WithPerPagePagination, WithSortingDate, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    public Production $editing;

    public $sortColumn = 'productions.date';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'productions.date'
        ],
        'sortDirection' => [
            'except' => 'desc',
        ],
    ];

    public $filters = [
        'storename' => '',
        'status' => '',
        'order_status' => '',
        'store_id' => null,
        'supplier_id' => null,
        'payment_type_id' => null,
    ];

    public function rules()
    {
        return [
            'editing.notes' => 'nullable',
            'editing.status' => 'required|in:1,2,3,4',
        ];
    }

    public function edit(Production $production)
    {
        $this->editing = $production;

        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();

        $this->editing['approved_by_id'] = Auth::user()->id;

        $this->editing->save();

        $this->showEditModal = false;
    }

    public function mount()
    {
        $this->stores = Store::orderBy('nickname', 'asc')->pluck('id', 'nickname');
    }

    public function getRowsQueryProperty()
    {
        $productions = Production::query()
            ->select(['productions.*', 'stores.name as storename'])
            ->join('stores', 'stores.id', '=', 'productions.store_id');

            foreach ($this->filters as $filter => $value) {
                    if (!empty($value)) {
                        $productions
                            ->when($filter == 'store_id', fn($productions) => $productions->whereRelation('store', 'id', $value))
                            ->when($filter == 'status', fn($productions) => $productions->where('productions.' . $filter, 'LIKE', '%' . $value . '%'));
                    }
                }

        if (Auth::user()->hasRole('staff')) {

                $productions->where('created_by_id', '=', Auth::user()->id);
        }

        return $this->applySorting($productions);
    }

    public function render()
    {
        return view('livewire.productions.productions-list', [
            'productions' => $this->rows,
        ]);
    }

     public function markAllAsValid()
    {
        Production::whereIn('id', $this->selectedRows)->update([
            'status' => '2',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }

    public function markAllAsBelumDiperiksa()
    {
        Production::whereIn('id', $this->selectedRows)->update([
            'status' => '1',
            'approved_by_id' => null,
        ]);

        $this->reset(['selectedRows']);
    }

    public function markAllAsPerbaiki()
    {
        Production::whereIn('id', $this->selectedRows)->update([
            'status' => '3',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }
}
