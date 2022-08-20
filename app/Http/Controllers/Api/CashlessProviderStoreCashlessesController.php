<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\CashlessProvider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\StoreCashlessResource;
use App\Http\Resources\StoreCashlessCollection;

class CashlessProviderStoreCashlessesController extends Controller
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

        $storeCashlesses = $cashlessProvider
            ->storeCashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new StoreCashlessCollection($storeCashlesses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashlessProvider $cashlessProvider
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CashlessProvider $cashlessProvider)
    {
        $this->authorize('create', StoreCashless::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'email' => ['required', 'email'],
            'username' => ['required', 'max:255', 'string'],
            'password' => ['required'],
            'no_telp' => ['required', 'max:255', 'string'],
            'parent_account_cashless_id' => [
                'nullable',
                'exists:parent_account_cashlesses,id',
            ],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $storeCashless = $cashlessProvider
            ->storeCashlesses()
            ->create($validated);

        return new StoreCashlessResource($storeCashless);
    }
}
