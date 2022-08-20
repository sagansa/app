<?php
namespace App\Http\Controllers\Api;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\ClosingStore;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingStoreCollection;

class VehicleClosingStoresController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Vehicle $vehicle
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Vehicle $vehicle)
    {
        $this->authorize('view', $vehicle);

        $search = $request->get('search', '');

        $closingStores = $vehicle
            ->closingStores()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingStoreCollection($closingStores);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Vehicle $vehicle
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Vehicle $vehicle,
        ClosingStore $closingStore
    ) {
        $this->authorize('update', $vehicle);

        $vehicle->closingStores()->syncWithoutDetaching([$closingStore->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Vehicle $vehicle
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Vehicle $vehicle,
        ClosingStore $closingStore
    ) {
        $this->authorize('update', $vehicle);

        $vehicle->closingStores()->detach($closingStore);

        return response()->noContent();
    }
}
