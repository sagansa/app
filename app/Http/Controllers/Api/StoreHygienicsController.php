<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HygienicResource;
use App\Http\Resources\HygienicCollection;

class StoreHygienicsController extends Controller
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

        $hygienics = $store
            ->hygienics()
            ->search($search)
            ->latest()
            ->paginate();

        return new HygienicCollection($hygienics);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', Hygienic::class);

        $validated = $request->validate([
            'status' => ['required', 'max:255', 'string'],
            'status' => ['required', 'max:255', 'string'],
            'notes' => ['required', 'max:255', 'string'],
            'created_by_id' => ['required', 'exists:users,id'],
            'updated_by_id' => ['required', 'exists:users,id'],
        ]);

        $hygienic = $store->hygienics()->create($validated);

        return new HygienicResource($hygienic);
    }
}
