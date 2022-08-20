<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\UtilityProvider;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtilityProviderResource;
use App\Http\Resources\UtilityProviderCollection;
use App\Http\Requests\UtilityProviderStoreRequest;
use App\Http\Requests\UtilityProviderUpdateRequest;

class UtilityProviderController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', UtilityProvider::class);

        $search = $request->get('search', '');

        $utilityProviders = UtilityProvider::search($search)
            ->latest()
            ->paginate();

        return new UtilityProviderCollection($utilityProviders);
    }

    /**
     * @param \App\Http\Requests\UtilityProviderStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UtilityProviderStoreRequest $request)
    {
        $this->authorize('create', UtilityProvider::class);

        $validated = $request->validated();

        $utilityProvider = UtilityProvider::create($validated);

        return new UtilityProviderResource($utilityProvider);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UtilityProvider $utilityProvider
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, UtilityProvider $utilityProvider)
    {
        $this->authorize('view', $utilityProvider);

        return new UtilityProviderResource($utilityProvider);
    }

    /**
     * @param \App\Http\Requests\UtilityProviderUpdateRequest $request
     * @param \App\Models\UtilityProvider $utilityProvider
     * @return \Illuminate\Http\Response
     */
    public function update(
        UtilityProviderUpdateRequest $request,
        UtilityProvider $utilityProvider
    ) {
        $this->authorize('update', $utilityProvider);

        $validated = $request->validated();

        $utilityProvider->update($validated);

        return new UtilityProviderResource($utilityProvider);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UtilityProvider $utilityProvider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, UtilityProvider $utilityProvider)
    {
        $this->authorize('delete', $utilityProvider);

        $utilityProvider->delete();

        return response()->noContent();
    }
}
