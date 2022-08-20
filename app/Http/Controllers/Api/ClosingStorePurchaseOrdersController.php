<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ClosingStore;
use App\Models\PurchaseOrder;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseOrderCollection;

class ClosingStorePurchaseOrdersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ClosingStore $closingStore)
    {
        $this->authorize('view', $closingStore);

        $search = $request->get('search', '');

        $purchaseOrders = $closingStore
            ->purchaseOrders()
            ->search($search)
            ->latest()
            ->paginate();

        return new PurchaseOrderCollection($purchaseOrders);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @param \App\Models\PurchaseOrder $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        ClosingStore $closingStore,
        PurchaseOrder $purchaseOrder
    ) {
        $this->authorize('update', $closingStore);

        $closingStore
            ->purchaseOrders()
            ->syncWithoutDetaching([$purchaseOrder->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @param \App\Models\PurchaseOrder $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        ClosingStore $closingStore,
        PurchaseOrder $purchaseOrder
    ) {
        $this->authorize('update', $closingStore);

        $closingStore->purchaseOrders()->detach($purchaseOrder);

        return response()->noContent();
    }
}
