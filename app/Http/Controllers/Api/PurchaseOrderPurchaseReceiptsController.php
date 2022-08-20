<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseReceipt;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseReceiptCollection;

class PurchaseOrderPurchaseReceiptsController extends Controller
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

        $purchaseReceipts = $purchaseOrder
            ->purchaseReceipts()
            ->search($search)
            ->latest()
            ->paginate();

        return new PurchaseReceiptCollection($purchaseReceipts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PurchaseOrder $purchaseOrder
     * @param \App\Models\PurchaseReceipt $purchaseReceipt
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        PurchaseOrder $purchaseOrder,
        PurchaseReceipt $purchaseReceipt
    ) {
        $this->authorize('update', $purchaseOrder);

        $purchaseOrder
            ->purchaseReceipts()
            ->syncWithoutDetaching([$purchaseReceipt->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PurchaseOrder $purchaseOrder
     * @param \App\Models\PurchaseReceipt $purchaseReceipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        PurchaseOrder $purchaseOrder,
        PurchaseReceipt $purchaseReceipt
    ) {
        $this->authorize('update', $purchaseOrder);

        $purchaseOrder->purchaseReceipts()->detach($purchaseReceipt);

        return response()->noContent();
    }
}
