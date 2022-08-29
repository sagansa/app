<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductionToResource;
use App\Http\Resources\ProductionToCollection;

class ProductProductionTosController extends Controller
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

        $productionTos = $product
            ->productionTos()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductionToCollection($productionTos);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $this->authorize('create', ProductionTo::class);

        $validated = $request->validate([
            'quantity' => ['required', 'numeric', 'gt:0'],
        ]);

        $productionTo = $product->productionTos()->create($validated);

        return new ProductionToResource($productionTo);
    }
}
