<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtilityResource;
use App\Http\Resources\UtilityCollection;

class StoreUtilitiesController extends Controller
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

        $utilities = $store
            ->utilities()
            ->search($search)
            ->latest()
            ->paginate();

        return new UtilityCollection($utilities);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', Utility::class);

        $validated = $request->validate([
            'number' => [
                'required',
                'unique:utilities,number',
                'max:255',
                'string',
            ],
            'name' => ['required', 'max:255', 'string'],
            'category' => ['required', 'max:255'],
            'unit_id' => ['required', 'exists:units,id'],
            'utility_provider_id' => [
                'required',
                'exists:utility_providers,id',
            ],
            'pre_post' => ['required', 'max:255'],
            'status' => ['required', 'max:255'],
        ]);

        $utility = $store->utilities()->create($validated);

        return new UtilityResource($utility);
    }
}
