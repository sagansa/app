<?php

namespace App\Http\Livewire\Presences;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSortingDate;
use App\Models\PaymentType;
use App\Models\Presence;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PresencesList extends Component
{
    use WithPerPagePagination, WithSortingDate, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    public Presence $editing;

    public $sortColumn = 'presences.created_at';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'presences.created_at'
        ],
        'sortDirection' => [
            'except' => 'asc',
        ],
    ];

    public $filters = [
        'status' => '',
        'payment_type_id' => null,
        'created_by_id' => null,
    ];

    public function mount()
    {
        $this->paymentTypes = PaymentType::orderBy('name', 'asc')->whereIn('id', ['1', '2'])->pluck('id', 'name');
        $this->users = User::orderBy('name', 'asc')->pluck('id', 'name');
    }

    public function getRowsQueryProperty()
    {
        $presences = Presence::query()
            ->select('*')
            ->join('payment_types', 'payment_types.id', '=', 'presences.payment_type_id');

            if (Auth::user()->hasRole('staff|supervisor|manager')) {

                $presences->where('created_by_id', '=', Auth::user()->id);

                foreach ($this->filters as $filter => $value) {
                    if (!empty($value)) {
                        $presences
                            ->when($filter == 'payment_type_id', fn($presences) => $presences->whereRelation('paymentType', 'id', $value))
                            ->when($filter == 'payment_status', fn($presences) => $presences->where('presences.' . $filter, 'LIKE', '%' . $value . '%'));
                    }
                }
            } elseif (Auth::user()->hasRole('super-admin')) {
                foreach ($this->filters as $filter => $value) {
                    if (!empty($value)) {
                        $presences
                            ->when($filter == 'payment_type_id', fn($presences) => $presences->whereRelation('paymentType', 'id', $value))
                            ->when($filter == 'created_by_id', fn($presences) => $presences->whereRelation('created_by', 'id', $value))
                            ->when($filter == 'status', fn($presences) => $presences->where('presences.' . $filter, 'LIKE', '%' . $value . '%'));
                    }
                }
            }

            return $this->applySorting($presences);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.presences.presences-list', [
            'presences' => $this->rows,
        ]);
    }

    public function markAllAsSudahDibayar()
    {
        Presence::whereIn('id', $this->selectedRows)->update([
            'status' => '2',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }

    public function markAllAsBelumDiperiksa()
    {
        Presence::whereIn('id', $this->selectedRows)->update([
            'status' => '1',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }

    public function markAllAsSiapDitransfer()
    {
        Presence::whereIn('id', $this->selectedRows)->update([
            'status' => '3',
            'approved_by_id' => Auth::user()->id,
        ]);

        $this->reset(['selectedRows']);
    }
}
