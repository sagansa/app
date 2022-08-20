<?php

namespace App\Http\Controllers\Api;

use App\Models\Production;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductionResource;
use App\Http\Resources\ProductionCollection;
use App\Http\Requests\ProductionStoreRequest;
use App\Http\Requests\ProductionUpdateRequest;

class ProductionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Production::class);

        $search = $request->get('search', '');

        $productions = Production::search($search)
            ->latest()
            ->paginate();

        return new ProductionCollection($productions);
    }

    /**
     * @param \App\Http\Requests\ProductionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductionStoreRequest $request)
    {
        $this->authorize('create', Production::class);

        $validated = $request->validated();

        $production = Production::create($validated);

        return new ProductionResource($production);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Production $production)
    {
        $this->authorize('view', $production);

        return new ProductionResource($production);
    }

    /**
     * @param \App\Http\Requests\ProductionUpdateRequest $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function update(
        ProductionUpdateRequest $request,
        Production $production
    ) {
        $this->authorize('update', $production);

        $validated = $request->validated();

        $production->update($validated);

        return new ProductionResource($production);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Production $production)
    {
        $this->authorize('delete', $production);

        $production->delete();

        return response()->noContent();
    }
}
