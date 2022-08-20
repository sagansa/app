<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\CashlessProvider;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashlessResource;
use App\Http\Resources\CashlessCollection;

class CashlessProviderCashlessesController extends Controller
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

        $cashlesses = $cashlessProvider
            ->cashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new CashlessCollection($cashlesses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashlessProvider $cashlessProvider
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CashlessProvider $cashlessProvider)
    {
        $this->authorize('create', Cashless::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:1024'],
            'bruto_apl' => ['required', 'max:255'],
            'netto_apl' => ['nullable', 'max:255'],
            'bruto_real' => ['nullable', 'max:255'],
            'netto_real' => ['nullable', 'max:255'],
            'image_canceled' => ['nullable', 'max:255', 'string'],
            'canceled' => ['required', 'numeric'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $cashless = $cashlessProvider->cashlesses()->create($validated);

        return new CashlessResource($cashless);
    }
}
