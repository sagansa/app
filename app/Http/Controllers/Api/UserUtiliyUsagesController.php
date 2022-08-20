<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtiliyUsageResource;
use App\Http\Resources\UtiliyUsageCollection;

class UserUtiliyUsagesController extends Controller
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

        $utiliyUsages = $user
            ->utiliyUsagesApproved()
            ->search($search)
            ->latest()
            ->paginate();

        return new UtiliyUsageCollection($utiliyUsages);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', UtiliyUsage::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        $utiliyUsage = $user->utiliyUsagesApproved()->create($validated);

        return new UtiliyUsageResource($utiliyUsage);
    }
}
