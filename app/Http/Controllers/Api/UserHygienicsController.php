<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HygienicResource;
use App\Http\Resources\HygienicCollection;

class UserHygienicsController extends Controller
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

        $hygienics = $user
            ->hygienicsUpdated()
            ->search($search)
            ->latest()
            ->paginate();

        return new HygienicCollection($hygienics);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Hygienic::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'status' => ['required', 'max:255', 'string'],
            'status' => ['required', 'max:255', 'string'],
            'notes' => ['required', 'max:255', 'string'],
        ]);

        $hygienic = $user->hygienicsUpdated()->create($validated);

        return new HygienicResource($hygienic);
    }
}
