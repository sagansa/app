<?php
namespace App\Http\Controllers\Api;

use App\Models\FuelService;
use Illuminate\Http\Request;
use App\Models\TransferFuelService;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransferFuelServiceCollection;

class FuelServiceTransferFuelServicesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FuelService $fuelService
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, FuelService $fuelService)
    {
        $this->authorize('view', $fuelService);

        $search = $request->get('search', '');

        $transferFuelServices = $fuelService
            ->transferFuelServices()
            ->search($search)
            ->latest()
            ->paginate();

        return new TransferFuelServiceCollection($transferFuelServices);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FuelService $fuelService
     * @param \App\Models\TransferFuelService $transferFuelService
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        FuelService $fuelService,
        TransferFuelService $transferFuelService
    ) {
        $this->authorize('update', $fuelService);

        $fuelService
            ->transferFuelServices()
            ->syncWithoutDetaching([$transferFuelService->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FuelService $fuelService
     * @param \App\Models\TransferFuelService $transferFuelService
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        FuelService $fuelService,
        TransferFuelService $transferFuelService
    ) {
        $this->authorize('update', $fuelService);

        $fuelService->transferFuelServices()->detach($transferFuelService);

        return response()->noContent();
    }
}
