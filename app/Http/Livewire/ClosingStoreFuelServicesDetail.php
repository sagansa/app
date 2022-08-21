<?php

namespace App\Http\Livewire;

use Image;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Vehicle;
use App\Models\FuelService;
use Livewire\WithPagination;
use App\Models\ClosingStore;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ClosingStoreFuelServicesDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public ClosingStore $closingStore;
    public FuelService $fuelService;
    public $vehiclesForSelect = [];
    public $fuelServiceImage;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New FuelService';

    protected $rules = [
        'fuelServiceImage' => ['nullable', 'image'],
        'fuelService.vehicle_id' => ['required', 'exists:vehicles,id'],
        'fuelService.fuel_service' => ['required'],
        'fuelService.km' => ['required', 'numeric'],
        'fuelService.liter' => ['required', 'numeric'],
        'fuelService.amount' => ['required', 'numeric'],
    ];

    public function mount(ClosingStore $closingStore)
    {
        $this->closingStore = $closingStore;
        $this->vehiclesForSelect = Vehicle::orderBy('no_register', 'asc')->whereIn('status', ['1'])->pluck('id', 'no_register');
        $this->resetFuelServiceData();
    }

    public function resetFuelServiceData()
    {
        $this->fuelService = new FuelService();

        $this->fuelServiceImage = null;
        $this->fuelService->vehicle_id = null;
        $this->fuelService->fuel_service = '1';

        $this->dispatchBrowserEvent('refresh');
    }

    public function newFuelService()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.closing_store_fuel_services.new_title');
        $this->resetFuelServiceData();

        $this->showModal();
    }

    public function editFuelService(FuelService $fuelService)
    {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.closing_store_fuel_services.edit_title'
        );
        $this->fuelService = $fuelService;

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

        if (!$this->fuelService->closing_store_id) {
            $this->authorize('create', FuelService::class);

            $this->fuelService->closing_store_id = $this->closingStore->id;
        } else {
            $this->authorize('update', $this->fuelService);
        }

        if ($this->fuelServiceImage) {
            // $this->fuelService->image = $this->fuelServiceImage->store(
            //     'public'
            // );

            $image = $this->fuelServiceImage;
            $imageName = Str::random() . '.' . $image->getClientOriginalExtension();
            $imageImg = Image::make($image->getRealPath())->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('jpg', 65);
            $imageImg->stream();
            Storage::disk('public')->put('images/fuel-services' . '/' . $imageName, $imageImg);

            $this->fuelService->image = $imageName;
        }

        $this->fuelService->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', ClosingStore::class);

        collect($this->selected)->each(function (string $id) {
            $fuelService = FuelService::findOrFail($id);

            if ($fuelService->image) {
                Storage::delete($fuelService->image);
            }

            $fuelService->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetFuelServiceData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->closingStore->fuelServices as $fuelService) {
            array_push($this->selected, $fuelService->id);
        }
    }

    public function render()
    {
        $this->totals = 0;

        foreach ($this->closingStore->fuelServices as $fuelService) {
            $this->totals += $fuelService['amount'];
        }

        return view('livewire.closing-store-fuel-services-detail', [
            'fuelServices' => $this->closingStore->fuelServices()->paginate(20),
        ]);
    }
}
