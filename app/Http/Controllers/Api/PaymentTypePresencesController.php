<?php

namespace App\Http\Controllers\Api;

use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PresenceResource;
use App\Http\Resources\PresenceCollection;

class PaymentTypePresencesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentType $paymentType
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PaymentType $paymentType)
    {
        $this->authorize('view', $paymentType);

        $search = $request->get('search', '');

        $presences = $paymentType
            ->presences()
            ->search($search)
            ->latest()
            ->paginate();

        return new PresenceCollection($presences);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentType $paymentType
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, PaymentType $paymentType)
    {
        $this->authorize('create', Presence::class);

        $validated = $request->validate([
            'closing_store_id' => ['required', 'exists:closing_stores,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required'],
            'created_by_id' => ['nullable', 'exists:users,id'],
        ]);

        $presence = $paymentType->presences()->create($validated);

        return new PresenceResource($presence);
    }
}
