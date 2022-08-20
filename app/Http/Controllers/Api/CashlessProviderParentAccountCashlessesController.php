<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\CashlessProvider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ParentAccountCashlessResource;
use App\Http\Resources\ParentAccountCashlessCollection;

class CashlessProviderParentAccountCashlessesController extends Controller
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

        $parentAccountCashlesses = $cashlessProvider
            ->parentAccountCashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new ParentAccountCashlessCollection($parentAccountCashlesses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashlessProvider $cashlessProvider
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CashlessProvider $cashlessProvider)
    {
        $this->authorize('create', ParentAccountCashless::class);

        $validated = $request->validate([
            'username' => ['nullable', 'max:255', 'string'],
            'password' => ['nullable'],
            'email' => ['nullable', 'email'],
            'no_telp' => ['nullable', 'max:255', 'string'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $parentAccountCashless = $cashlessProvider
            ->parentAccountCashlesses()
            ->create($validated);

        return new ParentAccountCashlessResource($parentAccountCashless);
    }
}
