<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HygieneResource;
use App\Http\Resources\HygieneCollection;

class UserHygienesController extends Controller
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

        $hygienes = $user
            ->hygienesApproved()
            ->search($search)
            ->latest()
            ->paginate();

        return new HygieneCollection($hygienes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Hygiene::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'status' => ['max:255', 'nullable'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        $hygiene = $user->hygienesApproved()->create($validated);

        return new HygieneResource($hygiene);
    }
}
