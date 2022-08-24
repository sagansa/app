<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\CashlessProvider;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCashlessResource;
use App\Http\Resources\UserCashlessCollection;

class CashlessProviderUserCashlessesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashlessProvider $cashlessProvider
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CashlessProvider $cashlessProvider)
    {
        $this->authorize('view', $cashlessProvider);

        $search = $request->get('search', '');

        $userCashlesses = $cashlessProvider
            ->userCashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCashlessCollection($userCashlesses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashlessProvider $cashlessProvider
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CashlessProvider $cashlessProvider)
    {
        $this->authorize('create', UserCashless::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'store_cashless_id' => ['required', 'exists:store_cashlesses,id'],
            'email' => ['nullable', 'email'],
            'username' => ['nullable', 'max:50', 'string'],
            'no_telp' => ['nullable', 'max:255', 'string'],
            'password' => ['nullable'],
            'status' => ['required', 'max:255'],
        ]);

        $userCashless = $cashlessProvider->userCashlesses()->create($validated);

        return new UserCashlessResource($userCashless);
    }
}
