<?php

namespace App\Http\Controllers\Api;

use App\Models\ClosingStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingStoreResource;
use App\Http\Resources\ClosingStoreCollection;
use App\Http\Requests\ClosingStoreStoreRequest;
use App\Http\Requests\ClosingStoreUpdateRequest;

class ClosingStoreController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ClosingStore::class);

        $search = $request->get('search', '');

        $closingStores = ClosingStore::search($search)
            ->latest()
            ->paginate();

        return new ClosingStoreCollection($closingStores);
    }

    /**
     * @param \App\Http\Requests\ClosingStoreStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClosingStoreStoreRequest $request)
    {
        $this->authorize('create', ClosingStore::class);

        $validated = $request->validated();

        $closingStore = ClosingStore::create($validated);

        return new ClosingStoreResource($closingStore);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ClosingStore $closingStore)
    {
        $this->authorize('view', $closingStore);

        return new ClosingStoreResource($closingStore);
    }

    /**
     * @param \App\Http\Requests\ClosingStoreUpdateRequest $request
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function update(
        ClosingStoreUpdateRequest $request,
        ClosingStore $closingStore
    ) {
        $this->authorize('update', $closingStore);

        $validated = $request->validated();

        $closingStore->update($validated);

        return new ClosingStoreResource($closingStore);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ClosingStore $closingStore)
    {
        $this->authorize('delete', $closingStore);

        $closingStore->delete();

        return response()->noContent();
    }
}
