<?php

namespace App\Http\Controllers\Api;

use App\Models\ClosingStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FuelServiceResource;
use App\Http\Resources\FuelServiceCollection;

class ClosingStoreFuelServicesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ClosingStore $closingStore)
    {
        $this->authorize('view', $closingStore);

        $search = $request->get('search', '');

        $fuelServices = $closingStore
            ->fuelServices()
            ->search($search)
            ->latest()
            ->paginate();

        return new FuelServiceCollection($fuelServices);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ClosingStore $closingStore)
    {
        $this->authorize('create', FuelService::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'fuel_service' => ['required|in:1,2'],
            'km' => ['required', 'numeric'],
            'liter' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $fuelService = $closingStore->fuelServices()->create($validated);

        return new FuelServiceResource($fuelService);
    }
}
