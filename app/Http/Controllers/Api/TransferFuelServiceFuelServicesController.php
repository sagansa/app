<?php
namespace App\Http\Controllers\Api;

use App\Models\FuelService;
use Illuminate\Http\Request;
use App\Models\TransferFuelService;
use App\Http\Controllers\Controller;
use App\Http\Resources\FuelServiceCollection;

class TransferFuelServiceFuelServicesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferFuelService $transferFuelService
     * @return \Illuminate\Http\Response
     */
    public function index(
        Request $request,
        TransferFuelService $transferFuelService
    ) {
        $this->authorize('view', $transferFuelService);

        $search = $request->get('search', '');

        $fuelServices = $transferFuelService
            ->fuelServices()
            ->search($search)
            ->latest()
            ->paginate();

        return new FuelServiceCollection($fuelServices);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferFuelService $transferFuelService
     * @param \App\Models\FuelService $fuelService
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        TransferFuelService $transferFuelService,
        FuelService $fuelService
    ) {
        $this->authorize('update', $transferFuelService);

        $transferFuelService
            ->fuelServices()
            ->syncWithoutDetaching([$fuelService->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferFuelService $transferFuelService
     * @param \App\Models\FuelService $fuelService
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        TransferFuelService $transferFuelService,
        FuelService $fuelService
    ) {
        $this->authorize('update', $transferFuelService);

        $transferFuelService->fuelServices()->detach($fuelService);

        return response()->noContent();
    }
}
