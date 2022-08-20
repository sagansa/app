<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\RemainingStock;
use App\Http\Controllers\Controller;
use App\Http\Resources\RemainingStockResource;
use App\Http\Resources\RemainingStockCollection;
use App\Http\Requests\RemainingStockStoreRequest;
use App\Http\Requests\RemainingStockUpdateRequest;

class RemainingStockController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', RemainingStock::class);

        $search = $request->get('search', '');

        $remainingStocks = RemainingStock::search($search)
            ->latest()
            ->paginate();

        return new RemainingStockCollection($remainingStocks);
    }

    /**
     * @param \App\Http\Requests\RemainingStockStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RemainingStockStoreRequest $request)
    {
        $this->authorize('create', RemainingStock::class);

        $validated = $request->validated();

        $remainingStock = RemainingStock::create($validated);

        return new RemainingStockResource($remainingStock);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RemainingStock $remainingStock
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, RemainingStock $remainingStock)
    {
        $this->authorize('view', $remainingStock);

        return new RemainingStockResource($remainingStock);
    }

    /**
     * @param \App\Http\Requests\RemainingStockUpdateRequest $request
     * @param \App\Models\RemainingStock $remainingStock
     * @return \Illuminate\Http\Response
     */
    public function update(
        RemainingStockUpdateRequest $request,
        RemainingStock $remainingStock
    ) {
        $this->authorize('update', $remainingStock);

        $validated = $request->validated();

        $remainingStock->update($validated);

        return new RemainingStockResource($remainingStock);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RemainingStock $remainingStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, RemainingStock $remainingStock)
    {
        $this->authorize('delete', $remainingStock);

        $remainingStock->delete();

        return response()->noContent();
    }
}
