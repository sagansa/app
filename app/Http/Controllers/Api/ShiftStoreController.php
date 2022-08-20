<?php

namespace App\Http\Controllers\Api;

use App\Models\ShiftStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShiftStoreResource;
use App\Http\Resources\ShiftStoreCollection;
use App\Http\Requests\ShiftStoreStoreRequest;
use App\Http\Requests\ShiftStoreUpdateRequest;

class ShiftStoreController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ShiftStore::class);

        $search = $request->get('search', '');

        $shiftStores = ShiftStore::search($search)
            ->latest()
            ->paginate();

        return new ShiftStoreCollection($shiftStores);
    }

    /**
     * @param \App\Http\Requests\ShiftStoreStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShiftStoreStoreRequest $request)
    {
        $this->authorize('create', ShiftStore::class);

        $validated = $request->validated();

        $shiftStore = ShiftStore::create($validated);

        return new ShiftStoreResource($shiftStore);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ShiftStore $shiftStore
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ShiftStore $shiftStore)
    {
        $this->authorize('view', $shiftStore);

        return new ShiftStoreResource($shiftStore);
    }

    /**
     * @param \App\Http\Requests\ShiftStoreUpdateRequest $request
     * @param \App\Models\ShiftStore $shiftStore
     * @return \Illuminate\Http\Response
     */
    public function update(
        ShiftStoreUpdateRequest $request,
        ShiftStore $shiftStore
    ) {
        $this->authorize('update', $shiftStore);

        $validated = $request->validated();

        $shiftStore->update($validated);

        return new ShiftStoreResource($shiftStore);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ShiftStore $shiftStore
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ShiftStore $shiftStore)
    {
        $this->authorize('delete', $shiftStore);

        $shiftStore->delete();

        return response()->noContent();
    }
}
