<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FuelService;
use App\Models\TransferFuelService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TransferFuelServiceFuelServicesDetail extends Component
{
    use AuthorizesRequests;

    public TransferFuelService $transferFuelService;
    public FuelService $fuelService;
    public $fuelServicesForSelect = [];
    public $fuel_service_id = null;

    public $showingModal = false;
    public $modalTitle = 'New FuelService';

    protected $rules = [
        'fuel_service_id' => ['required', 'exists:fuel_services,id'],
    ];

    public function mount(TransferFuelService $transferFuelService)
    {
        $this->transferFuelService = $transferFuelService;
        $this->fuelServicesForSelect = FuelService::pluck('image', 'id');
        $this->resetFuelServiceData();
    }

    public function resetFuelServiceData()
    {
        $this->fuelService = new FuelService();

        $this->fuel_service_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newFuelService()
    {
        $this->modalTitle = trans('crud.transfer_fuel_service.new_title');
        $this->resetFuelServiceData();

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

        $this->authorize('create', FuelService::class);

        $this->transferFuelService
            ->fuelServices()
            ->attach($this->fuelService_id, []);

        $this->hideModal();
    }

    public function detach($fuelService)
    {
        $this->authorize('delete-any', FuelService::class);

        $this->transferFuelService->fuelServices()->detach($fuelService);

        $this->resetFuelServiceData();
    }

    public function render()
    {
        return view('livewire.transfer-fuel-service-fuel-services-detail', [
            'transferFuelService' => $this->transferFuelService
                ->fuelServices()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
