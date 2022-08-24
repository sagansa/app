<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AccountCashlessResource;
use App\Http\Resources\AccountCashlessCollection;

class StoreAccountCashlessesController extends Controller
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

        $accountCashlesses = $store
            ->accountCashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new AccountCashlessCollection($accountCashlesses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', AccountCashless::class);

        $validated = $request->validate([
            'cashless_provider_id' => [
                'required',
                'exists:cashless_providers,id',
            ],
            'store_cashless_id' => ['required', 'exists:store_cashlesses,id'],
            'email' => ['nullable', 'email'],
            'username' => ['nullable', 'max:255', 'string'],
            'password' => ['nullable'],
            'no_telp' => ['nullable', 'string'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $accountCashless = $store->accountCashlesses()->create($validated);

        return new AccountCashlessResource($accountCashless);
    }
}
