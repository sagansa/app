<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HygieneResource;
use App\Http\Resources\HygieneCollection;

class StoreHygienesController extends Controller
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

        $hygienes = $store
            ->hygienes()
            ->search($search)
            ->latest()
            ->paginate();

        return new HygieneCollection($hygienes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', Hygiene::class);

        $validated = $request->validate([
            'status' => ['max:255', 'nullable'],
            'notes' => ['nullable', 'max:255', 'string'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
        ]);

        $hygiene = $store->hygienes()->create($validated);

        return new HygieneResource($hygiene);
    }
}
