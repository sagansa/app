<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ReceiptLoyverse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReceiptLoyverseResource;
use App\Http\Resources\ReceiptLoyverseCollection;
use App\Http\Requests\ReceiptLoyverseStoreRequest;
use App\Http\Requests\ReceiptLoyverseUpdateRequest;

class ReceiptLoyverseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ReceiptLoyverse::class);

        $search = $request->get('search', '');

        $receiptLoyverses = ReceiptLoyverse::search($search)
            ->latest()
            ->paginate();

        return new ReceiptLoyverseCollection($receiptLoyverses);
    }

    /**
     * @param \App\Http\Requests\ReceiptLoyverseStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReceiptLoyverseStoreRequest $request)
    {
        $this->authorize('create', ReceiptLoyverse::class);

        $validated = $request->validated();

        $receiptLoyverse = ReceiptLoyverse::create($validated);

        return new ReceiptLoyverseResource($receiptLoyverse);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ReceiptLoyverse $receiptLoyverse
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ReceiptLoyverse $receiptLoyverse)
    {
        $this->authorize('view', $receiptLoyverse);

        return new ReceiptLoyverseResource($receiptLoyverse);
    }

    /**
     * @param \App\Http\Requests\ReceiptLoyverseUpdateRequest $request
     * @param \App\Models\ReceiptLoyverse $receiptLoyverse
     * @return \Illuminate\Http\Response
     */
    public function update(
        ReceiptLoyverseUpdateRequest $request,
        ReceiptLoyverse $receiptLoyverse
    ) {
        $this->authorize('update', $receiptLoyverse);

        $validated = $request->validated();

        $receiptLoyverse->update($validated);

        return new ReceiptLoyverseResource($receiptLoyverse);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ReceiptLoyverse $receiptLoyverse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ReceiptLoyverse $receiptLoyverse)
    {
        $this->authorize('delete', $receiptLoyverse);

        $receiptLoyverse->delete();

        return response()->noContent();
    }
}
