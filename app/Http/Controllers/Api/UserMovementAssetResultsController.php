<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MovementAssetResultResource;
use App\Http\Resources\MovementAssetResultCollection;

class UserMovementAssetResultsController extends Controller
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

        $movementAssetResults = $user
            ->movementAssetResults()
            ->search($search)
            ->latest()
            ->paginate();

        return new MovementAssetResultCollection($movementAssetResults);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', MovementAssetResult::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'date' => ['required', 'date'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        $movementAssetResult = $user
            ->movementAssetResults()
            ->create($validated);

        return new MovementAssetResultResource($movementAssetResult);
    }
}
