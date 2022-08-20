<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtiliyUsageResource;
use App\Http\Resources\UtiliyUsageCollection;

class StoreUtiliyUsagesController extends Controller
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

        $utiliyUsages = $store
            ->utiliyUsages()
            ->search($search)
            ->latest()
            ->paginate();

        return new UtiliyUsageCollection($utiliyUsages);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', UtiliyUsage::class);

        $validated = $request->validate([
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
        ]);

        $utiliyUsage = $store->utiliyUsages()->create($validated);

        return new UtiliyUsageResource($utiliyUsage);
    }
}
