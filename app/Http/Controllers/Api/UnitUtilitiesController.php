<?php

namespace App\Http\Controllers\Api;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtilityResource;
use App\Http\Resources\UtilityCollection;

class UnitUtilitiesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Unit $unit)
    {
        $this->authorize('view', $unit);

        $search = $request->get('search', '');

        $utilities = $unit
            ->utilities()
            ->search($search)
            ->latest()
            ->paginate();

        return new UtilityCollection($utilities);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Unit $unit)
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
            'store_id' => ['required', 'exists:stores,id'],
            'category' => ['required', 'max:255'],
            'utility_provider_id' => [
                'required',
                'exists:utility_providers,id',
            ],
            'pre_post' => ['required', 'max:255'],
            'status' => ['required', 'max:255'],
        ]);

        $utility = $unit->utilities()->create($validated);

        return new UtilityResource($utility);
    }
}
