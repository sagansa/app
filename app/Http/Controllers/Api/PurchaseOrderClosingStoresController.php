<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ClosingStore;
use App\Models\PurchaseOrder;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingStoreCollection;

class PurchaseOrderClosingStoresController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PurchaseOrder $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PurchaseOrder $purchaseOrder)
    {
        $this->authorize('view', $purchaseOrder);

        $search = $request->get('search', '');

        $closingStores = $purchaseOrder
            ->closingStores()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingStoreCollection($closingStores);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PurchaseOrder $purchaseOrder
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        PurchaseOrder $purchaseOrder,
        ClosingStore $closingStore
    ) {
        $this->authorize('update', $purchaseOrder);

        $purchaseOrder
            ->closingStores()
            ->syncWithoutDetaching([$closingStore->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PurchaseOrder $purchaseOrder
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        PurchaseOrder $purchaseOrder,
        ClosingStore $closingStore
    ) {
        $this->authorize('update', $purchaseOrder);

        $purchaseOrder->closingStores()->detach($closingStore);

        return response()->noContent();
    }
}
