<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ReceiptByItemLoyverse;
use App\Http\Resources\ReceiptByItemLoyverseResource;
use App\Http\Resources\ReceiptByItemLoyverseCollection;
use App\Http\Requests\ReceiptByItemLoyverseStoreRequest;
use App\Http\Requests\ReceiptByItemLoyverseUpdateRequest;

class ReceiptByItemLoyverseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ReceiptByItemLoyverse::class);

        $search = $request->get('search', '');

        $receiptByItemLoyverses = ReceiptByItemLoyverse::search($search)
            ->latest()
            ->paginate();

        return new ReceiptByItemLoyverseCollection($receiptByItemLoyverses);
    }

    /**
     * @param \App\Http\Requests\ReceiptByItemLoyverseStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReceiptByItemLoyverseStoreRequest $request)
    {
        $this->authorize('create', ReceiptByItemLoyverse::class);

        $validated = $request->validated();

        $receiptByItemLoyverse = ReceiptByItemLoyverse::create($validated);

        return new ReceiptByItemLoyverseResource($receiptByItemLoyverse);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ReceiptByItemLoyverse $receiptByItemLoyverse
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        ReceiptByItemLoyverse $receiptByItemLoyverse
    ) {
        $this->authorize('view', $receiptByItemLoyverse);

        return new ReceiptByItemLoyverseResource($receiptByItemLoyverse);
    }

    /**
     * @param \App\Http\Requests\ReceiptByItemLoyverseUpdateRequest $request
     * @param \App\Models\ReceiptByItemLoyverse $receiptByItemLoyverse
     * @return \Illuminate\Http\Response
     */
    public function update(
        ReceiptByItemLoyverseUpdateRequest $request,
        ReceiptByItemLoyverse $receiptByItemLoyverse
    ) {
        $this->authorize('update', $receiptByItemLoyverse);

        $validated = $request->validated();

        $receiptByItemLoyverse->update($validated);

        return new ReceiptByItemLoyverseResource($receiptByItemLoyverse);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ReceiptByItemLoyverse $receiptByItemLoyverse
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        ReceiptByItemLoyverse $receiptByItemLoyverse
    ) {
        $this->authorize('delete', $receiptByItemLoyverse);

        $receiptByItemLoyverse->delete();

        return response()->noContent();
    }
}
