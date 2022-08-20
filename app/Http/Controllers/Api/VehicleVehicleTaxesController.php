<?php

namespace App\Http\Controllers\Api;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleTaxResource;
use App\Http\Resources\VehicleTaxCollection;

class VehicleVehicleTaxesController extends Controller
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

        $vehicleTaxes = $vehicle
            ->vehicleTaxes()
            ->search($search)
            ->latest()
            ->paginate();

        return new VehicleTaxCollection($vehicleTaxes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Vehicle $vehicle
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Vehicle $vehicle)
    {
        $this->authorize('create', VehicleTax::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'amount_tax' => ['required', 'max:255'],
            'expired_date' => ['required', 'date'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $vehicleTax = $vehicle->vehicleTaxes()->create($validated);

        return new VehicleTaxResource($vehicleTax);
    }
}
