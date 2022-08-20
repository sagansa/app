<?php

namespace App\Http\Controllers\Api;

use App\Models\Production;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductionFromResource;
use App\Http\Resources\ProductionFromCollection;

class ProductionProductionFromsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Production $production)
    {
        $this->authorize('view', $production);

        $search = $request->get('search', '');

        $productionFroms = $production
            ->productionFroms()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductionFromCollection($productionFroms);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Production $production)
    {
        $this->authorize('create', ProductionFrom::class);

        $validated = $request->validate([
            'purchase_order_product_id' => [
                'required',
                'exists:purchase_order_products,id',
            ],
        ]);

        $productionFrom = $production->productionFroms()->create($validated);

        return new ProductionFromResource($productionFrom);
    }
}
