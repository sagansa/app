<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\CashlessProvider;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminCashlessResource;
use App\Http\Resources\AdminCashlessCollection;

class CashlessProviderAdminCashlessesController extends Controller
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

        $adminCashlesses = $cashlessProvider
            ->adminCashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new AdminCashlessCollection($adminCashlesses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashlessProvider $cashlessProvider
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CashlessProvider $cashlessProvider)
    {
        $this->authorize('create', AdminCashless::class);

        $validated = $request->validate([
            'username' => ['nullable', 'max:50', 'string'],
            'email' => ['nullable', 'email'],
            'no_telp' => ['nullable', 'max:255', 'string'],
            'password' => ['nullable'],
        ]);

        $adminCashless = $cashlessProvider
            ->adminCashlesses()
            ->create($validated);

        return new AdminCashlessResource($adminCashless);
    }
}
