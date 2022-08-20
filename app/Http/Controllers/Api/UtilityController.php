<?php

namespace App\Http\Controllers\Api;

use App\Models\Utility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtilityResource;
use App\Http\Resources\UtilityCollection;
use App\Http\Requests\UtilityStoreRequest;
use App\Http\Requests\UtilityUpdateRequest;

class UtilityController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Utility::class);

        $search = $request->get('search', '');

        $utilities = Utility::search($search)
            ->latest()
            ->paginate();

        return new UtilityCollection($utilities);
    }

    /**
     * @param \App\Http\Requests\UtilityStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UtilityStoreRequest $request)
    {
        $this->authorize('create', Utility::class);

        $validated = $request->validated();

        $utility = Utility::create($validated);

        return new UtilityResource($utility);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Utility $utility
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Utility $utility)
    {
        $this->authorize('view', $utility);

        return new UtilityResource($utility);
    }

    /**
     * @param \App\Http\Requests\UtilityUpdateRequest $request
     * @param \App\Models\Utility $utility
     * @return \Illuminate\Http\Response
     */
    public function update(UtilityUpdateRequest $request, Utility $utility)
    {
        $this->authorize('update', $utility);

        $validated = $request->validated();

        $utility->update($validated);

        return new UtilityResource($utility);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Utility $utility
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Utility $utility)
    {
        $this->authorize('delete', $utility);

        $utility->delete();

        return response()->noContent();
    }
}
