<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PurchaseOrderResource;
use App\Http\Resources\PurchaseOrderCollection;
use App\Http\Requests\PurchaseOrderStoreRequest;
use App\Http\Requests\PurchaseOrderUpdateRequest;

class PurchaseOrderController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', PurchaseOrder::class);

        $search = $request->get('search', '');

        $purchaseOrders = PurchaseOrder::search($search)
            ->latest()
            ->paginate();

        return new PurchaseOrderCollection($purchaseOrders);
    }

    /**
     * @param \App\Http\Requests\PurchaseOrderStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseOrderStoreRequest $request)
    {
        $this->authorize('create', PurchaseOrder::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $purchaseOrder = PurchaseOrder::create($validated);

        return new PurchaseOrderResource($purchaseOrder);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PurchaseOrder $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PurchaseOrder $purchaseOrder)
    {
        $this->authorize('view', $purchaseOrder);

        return new PurchaseOrderResource($purchaseOrder);
    }

    /**
     * @param \App\Http\Requests\PurchaseOrderUpdateRequest $request
     * @param \App\Models\PurchaseOrder $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(
        PurchaseOrderUpdateRequest $request,
        PurchaseOrder $purchaseOrder
    ) {
        $this->authorize('update', $purchaseOrder);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($purchaseOrder->image) {
                Storage::delete($purchaseOrder->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $purchaseOrder->update($validated);

        return new PurchaseOrderResource($purchaseOrder);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PurchaseOrder $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PurchaseOrder $purchaseOrder)
    {
        $this->authorize('delete', $purchaseOrder);

        if ($purchaseOrder->image) {
            Storage::delete($purchaseOrder->image);
        }

        $purchaseOrder->delete();

        return response()->noContent();
    }
}
