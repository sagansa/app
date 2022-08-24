<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\AccountCashless;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashlessResource;
use App\Http\Resources\CashlessCollection;

class AccountCashlessCashlessesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AccountCashless $accountCashless
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, AccountCashless $accountCashless)
    {
        $this->authorize('view', $accountCashless);

        $search = $request->get('search', '');

        $cashlesses = $accountCashless
            ->cashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new CashlessCollection($cashlesses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AccountCashless $accountCashless
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AccountCashless $accountCashless)
    {
        $this->authorize('create', Cashless::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'bruto_apl' => ['required', 'numeric', 'min:0'],
            'netto_apl' => ['nullable', 'numeric', 'min:0'],
            'image_canceled' => ['image', 'nullable'],
            'canceled' => ['required', 'numeric', 'min:0'],
            'bruto_real' => ['nullable', 'numeric', 'min:0'],
            'netto_real' => ['nullable', 'numeric', 'min:0'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        if ($request->hasFile('image_canceled')) {
            $validated['image_canceled'] = $request
                ->file('image_canceled')
                ->store('public');
        }

        $cashless = $accountCashless->cashlesses()->create($validated);

        return new CashlessResource($cashless);
    }
}
