<?php

namespace App\Http\Controllers\Api;

use App\Models\Utility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtilityUsageResource;
use App\Http\Resources\UtilityUsageCollection;

class UtilityUtilityUsagesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Utility $utility
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Utility $utility)
    {
        $this->authorize('view', $utility);

        $search = $request->get('search', '');

        $utilityUsages = $utility
            ->utilityUsages()
            ->search($search)
            ->latest()
            ->paginate();

        return new UtilityUsageCollection($utilityUsages);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Utility $utility
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Utility $utility)
    {
        $this->authorize('create', UtilityUsage::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'result' => ['required', 'numeric'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $utilityUsage = $utility->utilityUsages()->create($validated);

        return new UtilityUsageResource($utilityUsage);
    }
}
