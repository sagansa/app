<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCashlessResource;
use App\Http\Resources\UserCashlessCollection;

class StoreUserCashlessesController extends Controller
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

        $userCashlesses = $store
            ->userCashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCashlessCollection($userCashlesses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', UserCashless::class);

        $validated = $request->validate([
            'email' => ['nullable', 'email'],
            'username' => ['nullable', 'max:50', 'string'],
            'no_telp' => ['nullable', 'max:255', 'string'],
            'password' => ['nullable'],
        ]);

        $userCashless = $store->userCashlesses()->create($validated);

        return new UserCashlessResource($userCashless);
    }
}
