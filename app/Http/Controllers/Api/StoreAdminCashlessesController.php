<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminCashlessResource;
use App\Http\Resources\AdminCashlessCollection;

class StoreAdminCashlessesController extends Controller
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

        $adminCashlesses = $store
            ->adminCashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new AdminCashlessCollection($adminCashlesses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', AdminCashless::class);

        $validated = $request->validate([
            'cashless_provider_id' => [
                'required',
                'exists:cashless_providers,id',
            ],
            'username' => ['nullable', 'max:50', 'string'],
            'email' => ['nullable', 'email'],
            'no_telp' => ['nullable', 'max:255', 'string'],
            'password' => ['nullable'],
        ]);

        $adminCashless = $store->adminCashlesses()->create($validated);

        return new AdminCashlessResource($adminCashless);
    }
}
