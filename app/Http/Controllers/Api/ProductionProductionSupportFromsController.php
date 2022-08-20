<?php

namespace App\Http\Controllers\Api;

use App\Models\Production;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductionSupportFromResource;
use App\Http\Resources\ProductionSupportFromCollection;

class ProductionProductionSupportFromsController extends Controller
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

        $productionSupportFroms = $production
            ->productionSupportFroms()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductionSupportFromCollection($productionSupportFroms);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Production $production)
    {
        $this->authorize('create', ProductionSupportFrom::class);

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'numeric'],
        ]);

        $productionSupportFrom = $production
            ->productionSupportFroms()
            ->create($validated);

        return new ProductionSupportFromResource($productionSupportFrom);
    }
}
