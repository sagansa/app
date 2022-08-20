<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConsumptionResource;
use App\Http\Resources\ConsumptionCollection;

class UserConsumptionsController extends Controller
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

        $consumptions = $user
            ->consumptions2()
            ->search($search)
            ->latest()
            ->paginate();

        return new ConsumptionCollection($consumptions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Consumption::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'date' => ['required', 'date'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        $consumption = $user->consumptions2()->create($validated);

        return new ConsumptionResource($consumption);
    }
}
