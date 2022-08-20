<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StockCardResource;
use App\Http\Resources\StockCardCollection;

class UserStockCardsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $stockCards = $user
            ->stockCards()
            ->search($search)
            ->latest()
            ->paginate();

        return new StockCardCollection($stockCards);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', StockCard::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'store_id' => ['required', 'exists:stores,id'],
        ]);

        $stockCard = $user->stockCards()->create($validated);

        return new StockCardResource($stockCard);
    }
}
