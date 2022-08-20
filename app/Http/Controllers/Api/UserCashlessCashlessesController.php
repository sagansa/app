<?php

namespace App\Http\Controllers\Api;

use App\Models\UserCashless;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashlessResource;
use App\Http\Resources\CashlessCollection;

class UserCashlessCashlessesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UserCashless $userCashless
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, UserCashless $userCashless)
    {
        $this->authorize('view', $userCashless);

        $search = $request->get('search', '');

        $cashlesses = $userCashless
            ->cashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new CashlessCollection($cashlesses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UserCashless $userCashless
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UserCashless $userCashless)
    {
        $this->authorize('create', Cashless::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'image_canceled' => ['image', 'nullable'],
            'canceled' => ['required', 'numeric'],
            'bruto_apl' => ['required', 'numeric'],
            'netto_apl' => ['nullable', 'numeric'],
            'bruto_real' => ['nullable', 'numeric'],
            'netto_real' => ['nullable', 'numeric'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        if ($request->hasFile('image_canceled')) {
            $validated['image_canceled'] = $request
                ->file('image_canceled')
                ->store('public');
        }

        $cashless = $userCashless->cashlesses()->create($validated);

        return new CashlessResource($cashless);
    }
}
