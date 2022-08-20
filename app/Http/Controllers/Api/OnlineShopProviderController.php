<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\OnlineShopProvider;
use App\Http\Controllers\Controller;
use App\Http\Resources\OnlineShopProviderResource;
use App\Http\Resources\OnlineShopProviderCollection;
use App\Http\Requests\OnlineShopProviderStoreRequest;
use App\Http\Requests\OnlineShopProviderUpdateRequest;

class OnlineShopProviderController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', OnlineShopProvider::class);

        $search = $request->get('search', '');

        $onlineShopProviders = OnlineShopProvider::search($search)
            ->latest()
            ->paginate();

        return new OnlineShopProviderCollection($onlineShopProviders);
    }

    /**
     * @param \App\Http\Requests\OnlineShopProviderStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OnlineShopProviderStoreRequest $request)
    {
        $this->authorize('create', OnlineShopProvider::class);

        $validated = $request->validated();

        $onlineShopProvider = OnlineShopProvider::create($validated);

        return new OnlineShopProviderResource($onlineShopProvider);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OnlineShopProvider $onlineShopProvider
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        OnlineShopProvider $onlineShopProvider
    ) {
        $this->authorize('view', $onlineShopProvider);

        return new OnlineShopProviderResource($onlineShopProvider);
    }

    /**
     * @param \App\Http\Requests\OnlineShopProviderUpdateRequest $request
     * @param \App\Models\OnlineShopProvider $onlineShopProvider
     * @return \Illuminate\Http\Response
     */
    public function update(
        OnlineShopProviderUpdateRequest $request,
        OnlineShopProvider $onlineShopProvider
    ) {
        $this->authorize('update', $onlineShopProvider);

        $validated = $request->validated();

        $onlineShopProvider->update($validated);

        return new OnlineShopProviderResource($onlineShopProvider);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OnlineShopProvider $onlineShopProvider
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        OnlineShopProvider $onlineShopProvider
    ) {
        $this->authorize('delete', $onlineShopProvider);

        $onlineShopProvider->delete();

        return response()->noContent();
    }
}
