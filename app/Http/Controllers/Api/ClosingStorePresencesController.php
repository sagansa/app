<?php

namespace App\Http\Controllers\Api;

use App\Models\ClosingStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PresenceResource;
use App\Http\Resources\PresenceCollection;

class ClosingStorePresencesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ClosingStore $closingStore)
    {
        $this->authorize('view', $closingStore);

        $search = $request->get('search', '');

        $presences = $closingStore
            ->presences()
            ->search($search)
            ->latest()
            ->paginate();

        return new PresenceCollection($presences);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ClosingStore $closingStore)
    {
        $this->authorize('create', Presence::class);

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'status' => ['required'],
            'created_by_id' => ['nullable', 'exists:users,id'],
        ]);

        $presence = $closingStore->presences()->create($validated);

        return new PresenceResource($presence);
    }
}
