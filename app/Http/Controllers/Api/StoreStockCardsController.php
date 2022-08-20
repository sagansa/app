<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StockCardResource;
use App\Http\Resources\StockCardCollection;

class StoreStockCardsController extends Controller
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

        $stockCards = $store
            ->stockCards()
            ->search($search)
            ->latest()
            ->paginate();

        return new StockCardCollection($stockCards);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', StockCard::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        $stockCard = $store->stockCards()->create($validated);

        return new StockCardResource($stockCard);
    }
}
