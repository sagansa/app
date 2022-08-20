<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductionResource;
use App\Http\Resources\ProductionCollection;

class StoreProductionsController extends Controller
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

        $productions = $store
            ->productions()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductionCollection($productions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', Production::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'notes' => ['nullable', 'max:255', 'string'],
            'status' => ['required', 'max:255'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
        ]);

        $production = $store->productions()->create($validated);

        return new ProductionResource($production);
    }
}
