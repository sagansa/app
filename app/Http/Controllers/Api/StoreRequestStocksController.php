<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RequestStockResource;
use App\Http\Resources\RequestStockCollection;

class StoreRequestStocksController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Store $store)
    {
        $this->authorize('view', $store);

        $search = $request->get('search', '');

        $requestStocks = $store
            ->requestStocks()
            ->search($search)
            ->latest()
            ->paginate();

        return new RequestStockCollection($requestStocks);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', RequestStock::class);

        $validated = $request->validate([
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
        ]);

        $requestStock = $store->requestStocks()->create($validated);

        return new RequestStockResource($requestStock);
    }
}
