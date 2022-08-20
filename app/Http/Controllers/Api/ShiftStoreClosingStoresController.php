<?php

namespace App\Http\Controllers\Api;

use App\Models\ShiftStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingStoreResource;
use App\Http\Resources\ClosingStoreCollection;

class ShiftStoreClosingStoresController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ShiftStore $shiftStore
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ShiftStore $shiftStore)
    {
        $this->authorize('view', $shiftStore);

        $search = $request->get('search', '');

        $closingStores = $shiftStore
            ->closingStores()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingStoreCollection($closingStores);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ShiftStore $shiftStore
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ShiftStore $shiftStore)
    {
        $this->authorize('create', ClosingStore::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
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

        $closingStore = $shiftStore->closingStores()->create($validated);

        return new ClosingStoreResource($closingStore);
    }
}
