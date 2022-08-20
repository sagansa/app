<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Employee;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\ContractEmployee;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EmployeeContractEmployees extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public Employee $employee;
    public ContractEmployee $contractEmployee;
    public $contractEmployeeFile;
    public $uploadIteration = 0;
    public $contractEmployeeFromDate;
    public $contractEmployeeUntilDate;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New ContractEmployee';

    protected $rules = [
        'contractEmployeeFile' => ['nullable', 'file'],
        'contractEmployeeFromDate' => ['required', 'date'],
        'contractEmployeeUntilDate' => ['required', 'date'],
        'contractEmployee.nominal_guarantee' => ['required', 'max:255'],
        'contractEmployee.guarantee' => ['required', 'max:255'],
    ];

    public function mount(Employee $employee)
    {
        $this->employee = $employee;
        $this->resetContractEmployeeData();
    }

    public function resetContractEmployeeData()
    {
        $this->contractEmployee = new ContractEmployee();

        $this->contractEmployeeFile = null;
        $this->contractEmployeeFromDate = null;
        $this->contractEmployeeUntilDate = null;
        $this->contractEmployee->guarantee = '1';

        $this->dispatchBrowserEvent('refresh');
    }

    public function newContractEmployee()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.employee_contract_employees.new_title');
        $this->resetContractEmployeeData();

        $this->showModal();
    }

    public function editContractEmployee(ContractEmployee $contractEmployee)
    {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.employee_contract_employees.edit_title'
        );
        $this->contractEmployee = $contractEmployee;

        $this->contractEmployeeFromDate = $this->contractEmployee->from_date->format(
            'Y-m-d'
        );
        $this->contractEmployeeUntilDate = $this->contractEmployee->until_date->format(
            'Y-m-d'
        );

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

        if (!$this->contractEmployee->employee_id) {
            $this->authorize('create', ContractEmployee::class);

            $this->contractEmployee->employee_id = $this->employee->id;
        } else {
            $this->authorize('update', $this->contractEmployee);
        }

        if ($this->contractEmployeeFile) {
            $this->contractEmployee->file = $this->contractEmployeeFile->store(
                'public'
            );
        }

        $this->contractEmployee->from_date = \Carbon\Carbon::parse(
            $this->contractEmployeeFromDate
        );
        $this->contractEmployee->until_date = \Carbon\Carbon::parse(
            $this->contractEmployeeUntilDate
        );

        $this->contractEmployee->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', ContractEmployee::class);

        collect($this->selected)->each(function (string $id) {
            $contractEmployee = ContractEmployee::findOrFail($id);

            if ($contractEmployee->file) {
                Storage::delete($contractEmployee->file);
            }

            $contractEmployee->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetContractEmployeeData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->employee->contractEmployees as $contractEmployee) {
            array_push($this->selected, $contractEmployee->id);
        }
    }

    public function render()
    {
        return view('livewire.employee-contract-employees', [
            'contractEmployees' => $this->employee
                ->contractEmployees()
                ->paginate(20),
        ]);
    }
}
