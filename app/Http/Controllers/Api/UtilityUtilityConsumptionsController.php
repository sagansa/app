<?php

namespace App\Http\Controllers\Api;

use App\Models\Utility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtilityConsumptionResource;
use App\Http\Resources\UtilityConsumptionCollection;

class UtilityUtilityConsumptionsController extends Controller
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

        $utilityConsumptions = $utility
            ->utilityReports()
            ->search($search)
            ->latest()
            ->paginate();

        return new UtilityConsumptionCollection($utilityConsumptions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Utility $utility
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Utility $utility)
    {
        $this->authorize('create', UtilityConsumption::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:1024'],
            'store_id' => ['required', 'exists:stores,id'],
            'result' => ['required', 'numeric'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $utilityConsumption = $utility->utilityReports()->create($validated);

        return new UtilityConsumptionResource($utilityConsumption);
    }
}
