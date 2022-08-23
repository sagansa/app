<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PresenceResource;
use App\Http\Resources\PresenceCollection;

class UserPresencesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $presences = $user
            ->presencesApproved()
            ->search($search)
            ->latest()
            ->paginate();

        return new PresenceCollection($presences);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Presence::class);

        $validated = $request->validate([
            'closing_store_id' => ['required', 'exists:closing_stores,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'status' => ['required'],
        ]);

        $presence = $user->presencesApproved()->create($validated);

        return new PresenceResource($presence);
    }
}
