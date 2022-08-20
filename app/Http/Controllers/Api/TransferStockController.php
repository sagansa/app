<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\TransferStock;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransferStockResource;
use App\Http\Resources\TransferStockCollection;
use App\Http\Requests\TransferStockStoreRequest;
use App\Http\Requests\TransferStockUpdateRequest;

class TransferStockController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', TransferStock::class);

        $search = $request->get('search', '');

        $transferStocks = TransferStock::search($search)
            ->latest()
            ->paginate();

        return new TransferStockCollection($transferStocks);
    }

    /**
     * @param \App\Http\Requests\TransferStockStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransferStockStoreRequest $request)
    {
        $this->authorize('create', TransferStock::class);

        $validated = $request->validated();

        $transferStock = TransferStock::create($validated);

        return new TransferStockResource($transferStock);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferStock $transferStock
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, TransferStock $transferStock)
    {
        $this->authorize('view', $transferStock);

        return new TransferStockResource($transferStock);
    }

    /**
     * @param \App\Http\Requests\TransferStockUpdateRequest $request
     * @param \App\Models\TransferStock $transferStock
     * @return \Illuminate\Http\Response
     */
    public function update(
        TransferStockUpdateRequest $request,
        TransferStock $transferStock
    ) {
        $this->authorize('update', $transferStock);

        $validated = $request->validated();

        $transferStock->update($validated);

        return new TransferStockResource($transferStock);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferStock $transferStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, TransferStock $transferStock)
    {
        $this->authorize('delete', $transferStock);

        $transferStock->delete();

        return response()->noContent();
    }
}
