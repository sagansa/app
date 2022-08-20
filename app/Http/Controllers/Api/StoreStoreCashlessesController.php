<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\StoreCashlessResource;
use App\Http\Resources\StoreCashlessCollection;

class StoreStoreCashlessesController extends Controller
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

        $storeCashlesses = $store
            ->storeCashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new StoreCashlessCollection($storeCashlesses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', StoreCashless::class);

        $validated = $request->validate([
            'cashless_provider_id' => [
                'required',
                'exists:cashless_providers,id',
            ],
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

        $storeCashless = $store->storeCashlesses()->create($validated);

        return new StoreCashlessResource($storeCashless);
    }
}
