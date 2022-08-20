<?php

namespace App\Http\Controllers\Api;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseOrderProductResource;
use App\Http\Resources\PurchaseOrderProductCollection;

class UnitPurchaseOrderProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Unit $unit)
    {
        $this->authorize('view', $unit);

        $search = $request->get('search', '');

        $purchaseOrderProducts = $unit
            ->purchaseOrderProducts()
            ->search($search)
            ->latest()
            ->paginate();

        return new PurchaseOrderProductCollection($purchaseOrderProducts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Unit $unit)
    {
        $this->authorize('create', PurchaseOrderProduct::class);

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity_product' => ['required', 'max:255'],
            'quantity_invoice' => ['required', 'max:255', 'string'],
            'subtotal_invoice' => ['required', 'max:255'],
            'status' => ['required', 'max:255'],
            'status' => ['required', 'max:255'],
        ]);

        $purchaseOrderProduct = $unit
            ->purchaseOrderProducts()
            ->create($validated);

        return new PurchaseOrderProductResource($purchaseOrderProduct);
    }
}
