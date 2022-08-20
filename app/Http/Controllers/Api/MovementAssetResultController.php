<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\MovementAssetResult;
use App\Http\Controllers\Controller;
use App\Http\Resources\MovementAssetResultResource;
use App\Http\Resources\MovementAssetResultCollection;
use App\Http\Requests\MovementAssetResultStoreRequest;
use App\Http\Requests\MovementAssetResultUpdateRequest;

class MovementAssetResultController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', MovementAssetResult::class);

        $search = $request->get('search', '');

        $movementAssetResults = MovementAssetResult::search($search)
            ->latest()
            ->paginate();

        return new MovementAssetResultCollection($movementAssetResults);
    }

    /**
     * @param \App\Http\Requests\MovementAssetResultStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MovementAssetResultStoreRequest $request)
    {
        $this->authorize('create', MovementAssetResult::class);

        $validated = $request->validated();

        $movementAssetResult = MovementAssetResult::create($validated);

        return new MovementAssetResultResource($movementAssetResult);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MovementAssetResult $movementAssetResult
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        MovementAssetResult $movementAssetResult
    ) {
        $this->authorize('view', $movementAssetResult);

        return new MovementAssetResultResource($movementAssetResult);
    }

    /**
     * @param \App\Http\Requests\MovementAssetResultUpdateRequest $request
     * @param \App\Models\MovementAssetResult $movementAssetResult
     * @return \Illuminate\Http\Response
     */
    public function update(
        MovementAssetResultUpdateRequest $request,
        MovementAssetResult $movementAssetResult
    ) {
        $this->authorize('update', $movementAssetResult);

        $validated = $request->validated();

        $movementAssetResult->update($validated);

        return new MovementAssetResultResource($movementAssetResult);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MovementAssetResult $movementAssetResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        MovementAssetResult $movementAssetResult
    ) {
        $this->authorize('delete', $movementAssetResult);

        $movementAssetResult->delete();

        return response()->noContent();
    }
}
