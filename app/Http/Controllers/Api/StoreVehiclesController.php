<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;
use App\Http\Resources\VehicleCollection;

class StoreVehiclesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Store $store)
    {
        $this->authorize('view', $store);

        $search = $request->get('search', '');

        $vehicles = $store
            ->vehicles()
            ->search($search)
            ->latest()
            ->paginate();

        return new VehicleCollection($vehicles);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', Vehicle::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'no_register' => ['required', 'max:15', 'string'],
            'type' => ['required', 'in:1,2,3'],
            'user_id' => ['required', 'exists:users,id'],
            'status' => ['required', 'in:1,2'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $vehicle = $store->vehicles()->create($validated);

        return new VehicleResource($vehicle);
    }
}
