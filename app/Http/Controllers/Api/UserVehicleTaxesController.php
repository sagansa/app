<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleTaxResource;
use App\Http\Resources\VehicleTaxCollection;

class UserVehicleTaxesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $vehicleTaxes = $user
            ->vehicleTaxes()
            ->search($search)
            ->latest()
            ->paginate();

        return new VehicleTaxCollection($vehicleTaxes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', VehicleTax::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'amount_tax' => ['required', 'max:255'],
            'expired_date' => ['required', 'date'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $vehicleTax = $user->vehicleTaxes()->create($validated);

        return new VehicleTaxResource($vehicleTax);
    }
}
