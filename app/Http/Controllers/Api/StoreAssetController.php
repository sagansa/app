<?php

namespace App\Http\Controllers\Api;

use App\Models\StoreAsset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoreAssetResource;
use App\Http\Resources\StoreAssetCollection;
use App\Http\Requests\StoreAssetStoreRequest;
use App\Http\Requests\StoreAssetUpdateRequest;

class StoreAssetController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', StoreAsset::class);

        $search = $request->get('search', '');

        $storeAssets = StoreAsset::search($search)
            ->latest()
            ->paginate();

        return new StoreAssetCollection($storeAssets);
    }

    /**
     * @param \App\Http\Requests\StoreAssetStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssetStoreRequest $request)
    {
        $this->authorize('create', StoreAsset::class);

        $validated = $request->validated();

        $storeAsset = StoreAsset::create($validated);

        return new StoreAssetResource($storeAsset);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StoreAsset $storeAsset
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, StoreAsset $storeAsset)
    {
        $this->authorize('view', $storeAsset);

        return new StoreAssetResource($storeAsset);
    }

    /**
     * @param \App\Http\Requests\StoreAssetUpdateRequest $request
     * @param \App\Models\StoreAsset $storeAsset
     * @return \Illuminate\Http\Response
     */
    public function update(
        StoreAssetUpdateRequest $request,
        StoreAsset $storeAsset
    ) {
        $this->authorize('update', $storeAsset);

        $validated = $request->validated();

        $storeAsset->update($validated);

        return new StoreAssetResource($storeAsset);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StoreAsset $storeAsset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, StoreAsset $storeAsset)
    {
        $this->authorize('delete', $storeAsset);

        $storeAsset->delete();

        return response()->noContent();
    }
}
