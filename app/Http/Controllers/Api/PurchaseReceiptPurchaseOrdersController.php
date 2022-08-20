<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseReceipt;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseOrderCollection;

class PurchaseReceiptPurchaseOrdersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PurchaseReceipt $purchaseReceipt
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PurchaseReceipt $purchaseReceipt)
    {
        $this->authorize('view', $purchaseReceipt);

        $search = $request->get('search', '');

        $purchaseOrders = $purchaseReceipt
            ->purchaseOrders()
            ->search($search)
            ->latest()
            ->paginate();

        return new PurchaseOrderCollection($purchaseOrders);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PurchaseReceipt $purchaseReceipt
     * @param \App\Models\PurchaseOrder $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        PurchaseReceipt $purchaseReceipt,
        PurchaseOrder $purchaseOrder
    ) {
        $this->authorize('update', $purchaseReceipt);

        $purchaseReceipt
            ->purchaseOrders()
            ->syncWithoutDetaching([$purchaseOrder->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PurchaseReceipt $purchaseReceipt
     * @param \App\Models\PurchaseOrder $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        PurchaseReceipt $purchaseReceipt,
        PurchaseOrder $purchaseOrder
    ) {
        $this->authorize('update', $purchaseReceipt);

        $purchaseReceipt->purchaseOrders()->detach($purchaseOrder);

        return response()->noContent();
    }
}
