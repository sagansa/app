<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtilityUsageResource;
use App\Http\Resources\UtilityUsageCollection;

class StoreUtilityUsagesController extends Controller
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

        $utilityUsages = $store
            ->utiliyUsages()
            ->search($search)
            ->latest()
            ->paginate();

        return new UtilityUsageCollection($utilityUsages);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', UtilityUsage::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'utility_id' => ['required', 'exists:utilities,id'],
            'result' => ['required', 'numeric'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $utilityUsage = $store->utiliyUsages()->create($validated);

        return new UtilityUsageResource($utilityUsage);
    }
}
