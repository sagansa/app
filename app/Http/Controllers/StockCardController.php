<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Store;
use App\Models\StockCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StockCardStoreRequest;
use App\Http\Requests\StockCardUpdateRequest;

class StockCardController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', StockCard::class);

        $search = $request->get('search', '');

        $stockCards = StockCard::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.stock_cards.index', compact('stockCards', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $stores = Store::orderBy('name', 'asc')
            ->whereIn('status', ['2', '4', '6', '7'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view('app.stock_cards.create', compact('stores', 'users'));
    }

    /**
     * @param \App\Http\Requests\StockCardStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockCardStoreRequest $request)
    {
        $this->authorize('create', StockCard::class);

        $validated = $request->validated();

        $validated['user_id'] = auth()->user()->id;

        $stockCard = StockCard::create($validated);

        return redirect()
            ->route('stock-cards.edit', $stockCard)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StockCard $stockCard
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, StockCard $stockCard)
    {
        $this->authorize('view', $stockCard);

        return view('app.stock_cards.show', compact('stockCard'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StockCard $stockCard
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, StockCard $stockCard)
    {
        $this->authorize('update', $stockCard);

        $stores = Store::orderBy('name', 'asc')
            ->whereIn('status', ['2', '4', '6', '7'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.stock_cards.edit',
            compact('stockCard', 'stores', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\StockCardUpdateRequest $request
     * @param \App\Models\StockCard $stockCard
     * @return \Illuminate\Http\Response
     */
    public function update(
        StockCardUpdateRequest $request,
        StockCard $stockCard
    ) {
        $this->authorize('update', $stockCard);

        $validated = $request->validated();

        $stockCard->update($validated);

        return redirect()
            ->route('stock-cards.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StockCard $stockCard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, StockCard $stockCard)
    {
        $this->authorize('delete', $stockCard);

        $stockCard->delete();

        return redirect()
            ->route('stock-cards.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
