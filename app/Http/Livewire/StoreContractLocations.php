<?php

namespace App\Http\Livewire;

use App\Models\Store;
use Livewire\Component;
use App\Models\Regency;
use App\Models\Village;
use App\Models\Province;
use App\Models\District;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\ContractLocation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StoreContractLocations extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public Store $store;
    public ContractLocation $contractLocation;
    public $provincesForSelect = [];
    public $regenciesForSelect = [];
    public $districtsForSelect = [];
    public $villagesForSelect = [];
    public $contractLocationFile;
    public $uploadIteration = 0;
    public $contractLocationFromDate;
    public $contractLocationUntilDate;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New ContractLocation';

    protected $rules = [
        'contractLocationFile' => ['nullable', 'file'],
        'contractLocation.address' => ['required', 'max:255', 'string'],
        'contractLocation.province_id' => ['nullable', 'exists:provinces,id'],
        'contractLocation.regency_id' => ['nullable', 'exists:regencies,id'],
        'contractLocation.district_id' => ['nullable', 'exists:districts,id'],
        'contractLocation.village_id' => ['nullable', 'exists:villages,id'],
        'contractLocation.codepos' => [
            'nullable',
            'numeric',
            'min:0',
            'digits:5',
        ],
        'contractLocation.gps_location' => ['nullable', 'max:255', 'string'],
        'contractLocationFromDate' => ['required', 'date'],
        'contractLocationUntilDate' => ['required', 'date'],
        'contractLocation.contact_person' => ['required', 'max:255', 'string'],
        'contractLocation.no_contact_person' => [
            'required',
            'numeric',
            'min:0',
            'digits_between:8,16',
        ],
        'contractLocation.nominal_contract_per_year' => [
            'required',
            'numeric',
            'min:0',
        ],
    ];

    public function mount(Store $store)
    {
        $this->store = $store;
        $this->provincesForSelect = Province::pluck('name', 'id');
        $this->regenciesForSelect = Regency::pluck('name', 'id');
        $this->districtsForSelect = District::pluck('name', 'id');
        $this->villagesForSelect = Village::pluck('name', 'id');
        $this->resetContractLocationData();
    }

    public function resetContractLocationData()
    {
        $this->contractLocation = new ContractLocation();

        $this->contractLocationFile = null;
        $this->contractLocationFromDate = null;
        $this->contractLocationUntilDate = null;
        $this->contractLocation->province_id = null;
        $this->contractLocation->regency_id = null;
        $this->contractLocation->district_id = null;
        $this->contractLocation->village_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newContractLocation()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.store_contract_locations.new_title');
        $this->resetContractLocationData();

        $this->showModal();
    }

    public function editContractLocation(ContractLocation $contractLocation)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.store_contract_locations.edit_title');
        $this->contractLocation = $contractLocation;

        $this->contractLocationFromDate = $this->contractLocation->from_date->format(
            'Y-m-d'
        );
        $this->contractLocationUntilDate = $this->contractLocation->until_date->format(
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

        if (!$this->contractLocation->store_id) {
            $this->authorize('create', ContractLocation::class);

            $this->contractLocation->store_id = $this->store->id;
        } else {
            $this->authorize('update', $this->contractLocation);
        }

        if ($this->contractLocationFile) {
            $this->contractLocation->file = $this->contractLocationFile->store(
                'public'
            );
        }

        $this->contractLocation->from_date = \Carbon\Carbon::parse(
            $this->contractLocationFromDate
        );
        $this->contractLocation->until_date = \Carbon\Carbon::parse(
            $this->contractLocationUntilDate
        );

        $this->contractLocation->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', ContractLocation::class);

        collect($this->selected)->each(function (string $id) {
            $contractLocation = ContractLocation::findOrFail($id);

            if ($contractLocation->file) {
                Storage::delete($contractLocation->file);
            }

            $contractLocation->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetContractLocationData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->store->contractLocations as $contractLocation) {
            array_push($this->selected, $contractLocation->id);
        }
    }

    public function render()
    {
        return view('livewire.store-contract-locations', [
            'contractLocations' => $this->store
                ->contractLocations()
                ->paginate(20),
        ]);
    }
}
