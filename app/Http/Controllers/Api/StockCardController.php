<?php

namespace App\Http\Controllers\Api;

use App\Models\StockCard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StockCardResource;
use App\Http\Resources\StockCardCollection;
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
            ->paginate();

        return new StockCardCollection($stockCards);
    }

    /**
     * @param \App\Http\Requests\StockCardStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockCardStoreRequest $request)
    {
        $this->authorize('create', StockCard::class);

        $validated = $request->validated();

        $stockCard = StockCard::create($validated);

        return new StockCardResource($stockCard);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StockCard $stockCard
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, StockCard $stockCard)
    {
        $this->authorize('view', $stockCard);

        return new StockCardResource($stockCard);
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

        return new StockCardResource($stockCard);
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

        return response()->noContent();
    }
}
