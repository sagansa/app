<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PurchaseReceipt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PurchaseReceiptResource;
use App\Http\Resources\PurchaseReceiptCollection;
use App\Http\Requests\PurchaseReceiptStoreRequest;
use App\Http\Requests\PurchaseReceiptUpdateRequest;

class PurchaseReceiptController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', PurchaseReceipt::class);

        $search = $request->get('search', '');

        $purchaseReceipts = PurchaseReceipt::search($search)
            ->latest()
            ->paginate();

        return new PurchaseReceiptCollection($purchaseReceipts);
    }

    /**
     * @param \App\Http\Requests\PurchaseReceiptStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseReceiptStoreRequest $request)
    {
        $this->authorize('create', PurchaseReceipt::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $purchaseReceipt = PurchaseReceipt::create($validated);

        return new PurchaseReceiptResource($purchaseReceipt);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PurchaseReceipt $purchaseReceipt
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PurchaseReceipt $purchaseReceipt)
    {
        $this->authorize('view', $purchaseReceipt);

        return new PurchaseReceiptResource($purchaseReceipt);
    }

    /**
     * @param \App\Http\Requests\PurchaseReceiptUpdateRequest $request
     * @param \App\Models\PurchaseReceipt $purchaseReceipt
     * @return \Illuminate\Http\Response
     */
    public function update(
        PurchaseReceiptUpdateRequest $request,
        PurchaseReceipt $purchaseReceipt
    ) {
        $this->authorize('update', $purchaseReceipt);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($purchaseReceipt->image) {
                Storage::delete($purchaseReceipt->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $purchaseReceipt->update($validated);

        return new PurchaseReceiptResource($purchaseReceipt);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PurchaseReceipt $purchaseReceipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PurchaseReceipt $purchaseReceipt)
    {
        $this->authorize('delete', $purchaseReceipt);

        if ($purchaseReceipt->image) {
            Storage::delete($purchaseReceipt->image);
        }

        $purchaseReceipt->delete();

        return response()->noContent();
    }
}
