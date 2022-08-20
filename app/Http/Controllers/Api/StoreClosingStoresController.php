<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingStoreResource;
use App\Http\Resources\ClosingStoreCollection;

class StoreClosingStoresController extends Controller
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

        $closingStores = $store
            ->closingStores()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingStoreCollection($closingStores);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', ClosingStore::class);

        $validated = $request->validate([
            'shift_store_id' => ['required', 'exists:shift_stores,id'],
            'date' => ['required', 'date'],
            'cash_from_yesterday' => ['required'],
            'cash_for_tomorrow' => ['required'],
            'transfer_by_id' => ['required', 'exists:users,id'],
            'total_cash_transfer' => ['required'],
            'status' => ['required', 'max:255'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        $closingStore = $store->closingStores()->create($validated);

        return new ClosingStoreResource($closingStore);
    }
}
