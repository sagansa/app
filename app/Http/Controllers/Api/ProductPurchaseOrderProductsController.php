<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseOrderProductResource;
use App\Http\Resources\PurchaseOrderProductCollection;

class ProductPurchaseOrderProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Product $product)
    {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $purchaseOrderProducts = $product
            ->purchaseOrderProducts()
            ->search($search)
            ->latest()
            ->paginate();

        return new PurchaseOrderProductCollection($purchaseOrderProducts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $this->authorize('create', PurchaseOrderProduct::class);

        $validated = $request->validate([
            'quantity_product' => ['required', 'numeric', 'gt:0'],
            'unit_id' => ['required', 'exists:units,id'],
            'quantity_invoice' => ['required', 'numeric', 'gt:0'],
            'subtotal_invoice' => ['required', 'numeric', 'gt:0'],
            'status' => ['required'],
        ]);

        $purchaseOrderProduct = $product
            ->purchaseOrderProducts()
            ->create($validated);

        return new PurchaseOrderProductResource($purchaseOrderProduct);
    }
}
