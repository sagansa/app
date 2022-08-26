<?php

namespace App\Http\Livewire\ClosingCouriers;

use App\Http\Livewire\DataTables\WithBulkAction;
use App\Http\Livewire\DataTables\WithCachedRows;
use App\Http\Livewire\DataTables\WithFilter;
use App\Http\Livewire\DataTables\WithModal;
use App\Http\Livewire\DataTables\WithPerPagePagination;
use App\Http\Livewire\DataTables\WithSorting;
use App\Models\Bank;
use App\Models\ClosingCourier;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ClosingCouriersList extends Component
{
    use WithPerPagePagination, WithSorting, WithModal, WithBulkAction, WithCachedRows, WithFilter;

    public ClosingCourier $editing;

    public $sortColumn = 'closing_couriers.created_at';

    protected $queryString = [
        'sortColumn' => [
        'except' => 'cloasing_couriers.created_at'
        ],
        'sortDirection' => [
            'except' => 'desc',
        ],
    ];

    public $filters = [
        'bank_id' => null,
        'status' => '',
        'bankname' => '',
    ];

    public function mount()
    {
        $this->banks = Bank::orderBy('name', 'asc')->pluck('id', 'name');
    }

    public function getRowsQueryProperty()
    {
        $closingCouriers = ClosingCourier::query()
            ->select(['closing_couriers.*', 'banks.name as bankname'])
            ->join('banks', 'banks.id', '=', 'closing_couriers.bank_id');

        foreach ($this->filters as $filter => $value) {
            if (!empty($value)) {
                $closingCouriers
                    ->when($filter == 'bank_id', fn($closingCouriers) => $closingCouriers->whereRelation('bank', 'id', $value))
                    ->when($filter == 'status', fn($closingCouriers) => $closingCouriers->where('closing_couriers.' . $filter, 'LIKE', '%' . $value . '%'));
            }
        }

        $closingCouriers->withSum('closingStores', 'total_cash_transfer')->get();

        return $this->applySorting($closingCouriers);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function changeStatus(ClosingCourier $closingCourier, $status)
    {
        Validator::make(['status' => $status], [
			'status' => [
				'required',
				Rule::in(ClosingCourier::STATUS_BELUM_DIPERIKSA, ClosingCourier::STATUS_VALID, ClosingCourier::STATUS_PERBAIKI),
			],
		])->validate();

		$closingCourier->update(['status' => $status]);

		$this->dispatchBrowserEvent('updated', ['message' => "Status changed to {$status} successfully."]);
    }

    public function render()
    {
        return view('livewire.closing-couriers.closing-couriers-list', [
            'closingCouriers' => $this->rows,
        ]);
    }
}
