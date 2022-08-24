<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\StoreCashless;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AccountCashlessResource;
use App\Http\Resources\AccountCashlessCollection;

class StoreCashlessAccountCashlessesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StoreCashless $storeCashless
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, StoreCashless $storeCashless)
    {
        $this->authorize('view', $storeCashless);

        $search = $request->get('search', '');

        $accountCashlesses = $storeCashless
            ->accountCashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new AccountCashlessCollection($accountCashlesses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StoreCashless $storeCashless
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, StoreCashless $storeCashless)
    {
        $this->authorize('create', AccountCashless::class);

        $validated = $request->validate([
            'cashless_provider_id' => [
                'required',
                'exists:cashless_providers,id',
            ],
            'store_id' => ['required', 'exists:stores,id'],
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

        $accountCashless = $storeCashless
            ->accountCashlesses()
            ->create($validated);

        return new AccountCashlessResource($accountCashless);
    }
}
