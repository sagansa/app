<?php

namespace App\Http\Controllers\Api;

use App\Models\RequestStock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RequestStockResource;
use App\Http\Resources\RequestStockCollection;
use App\Http\Requests\RequestStockStoreRequest;
use App\Http\Requests\RequestStockUpdateRequest;

class RequestStockController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', RequestStock::class);

        $search = $request->get('search', '');

        $requestStocks = RequestStock::search($search)
            ->latest()
            ->paginate();

        return new RequestStockCollection($requestStocks);
    }

    /**
     * @param \App\Http\Requests\RequestStockStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestStockStoreRequest $request)
    {
        $this->authorize('create', RequestStock::class);

        $validated = $request->validated();

        $requestStock = RequestStock::create($validated);

        return new RequestStockResource($requestStock);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RequestStock $requestStock
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, RequestStock $requestStock)
    {
        $this->authorize('view', $requestStock);

        return new RequestStockResource($requestStock);
    }

    /**
     * @param \App\Http\Requests\RequestStockUpdateRequest $request
     * @param \App\Models\RequestStock $requestStock
     * @return \Illuminate\Http\Response
     */
    public function update(
        RequestStockUpdateRequest $request,
        RequestStock $requestStock
    ) {
        $this->authorize('update', $requestStock);

        $validated = $request->validated();

        $requestStock->update($validated);

        return new RequestStockResource($requestStock);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RequestStock $requestStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, RequestStock $requestStock)
    {
        $this->authorize('delete', $requestStock);

        $requestStock->delete();

        return response()->noContent();
    }
}
