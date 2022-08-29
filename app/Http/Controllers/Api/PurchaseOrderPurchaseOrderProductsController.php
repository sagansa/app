<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseOrderProductResource;
use App\Http\Resources\PurchaseOrderProductCollection;

class PurchaseOrderPurchaseOrderProductsController extends Controller
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

        $purchaseOrderProducts = $purchaseOrder
            ->purchaseOrderProducts()
            ->search($search)
            ->latest()
            ->paginate();

        return new PurchaseOrderProductCollection($purchaseOrderProducts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PurchaseOrder $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, PurchaseOrder $purchaseOrder)
    {
        $this->authorize('create', PurchaseOrderProduct::class);

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity_product' => ['required', 'numeric', 'gt:0'],
            'unit_id' => ['required', 'exists:units,id'],
            'quantity_invoice' => ['required', 'numeric', 'gt:0'],
            'subtotal_invoice' => ['required', 'numeric', 'gt:0'],
            'status' => ['required'],
        ]);

        $purchaseOrderProduct = $purchaseOrder
            ->purchaseOrderProducts()
            ->create($validated);

        return new PurchaseOrderProductResource($purchaseOrderProduct);
    }
}
