<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductionSupportFromResource;
use App\Http\Resources\ProductionSupportFromCollection;

class ProductProductionSupportFromsController extends Controller
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

        $productionSupportFroms = $product
            ->productionSupportFroms()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductionSupportFromCollection($productionSupportFroms);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $this->authorize('create', ProductionSupportFrom::class);

        $validated = $request->validate([
            'quantity' => ['required', 'numeric'],
        ]);

        $productionSupportFrom = $product
            ->productionSupportFroms()
            ->create($validated);

        return new ProductionSupportFromResource($productionSupportFrom);
    }
}
