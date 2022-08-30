<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtilityUsageResource;
use App\Http\Resources\UtilityUsageCollection;

class UserUtilityUsagesController extends Controller
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

        $utilityUsages = $user
            ->utiliyUsagesApproved()
            ->search($search)
            ->latest()
            ->paginate();

        return new UtilityUsageCollection($utilityUsages);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', UtilityUsage::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'utility_id' => ['required', 'exists:utilities,id'],
            'result' => ['required', 'numeric'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $utilityUsage = $user->utiliyUsagesApproved()->create($validated);

        return new UtilityUsageResource($utilityUsage);
    }
}
