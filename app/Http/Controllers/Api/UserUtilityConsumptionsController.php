<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtilityConsumptionResource;
use App\Http\Resources\UtilityConsumptionCollection;

class UserUtilityConsumptionsController extends Controller
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

        $utilityConsumptions = $user
            ->utilityConsumptionsApproved()
            ->search($search)
            ->latest()
            ->paginate();

        return new UtilityConsumptionCollection($utilityConsumptions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', UtilityConsumption::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:1024'],
            'store_id' => ['required', 'exists:stores,id'],
            'utility_id' => ['required', 'exists:utilities,id'],
            'result' => ['required', 'numeric'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $utilityConsumption = $user
            ->utilityConsumptionsApproved()
            ->create($validated);

        return new UtilityConsumptionResource($utilityConsumption);
    }
}
