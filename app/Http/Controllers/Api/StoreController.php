<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Http\Resources\StoreCollection;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\StoreUpdateRequest;

class StoreController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Store::class);

        $search = $request->get('search', '');

        $stores = Store::search($search)
            ->latest()
            ->paginate();

        return new StoreCollection($stores);
    }

    /**
     * @param \App\Http\Requests\StoreStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStoreRequest $request)
    {
        $this->authorize('create', Store::class);

        $validated = $request->validated();

        $store = Store::create($validated);

        return new StoreResource($store);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Store $store)
    {
        $this->authorize('view', $store);

        return new StoreResource($store);
    }

    /**
     * @param \App\Http\Requests\StoreUpdateRequest $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateRequest $request, Store $store)
    {
        $this->authorize('update', $store);

        $validated = $request->validated();

        $store->update($validated);

        return new StoreResource($store);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Store $store)
    {
        $this->authorize('delete', $store);

        $store->delete();

        return response()->noContent();
    }
}
