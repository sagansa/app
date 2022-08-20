<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductGroupResource;
use App\Http\Resources\ProductGroupCollection;
use App\Http\Requests\ProductGroupStoreRequest;
use App\Http\Requests\ProductGroupUpdateRequest;

class ProductGroupController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ProductGroup::class);

        $search = $request->get('search', '');

        $productGroups = ProductGroup::search($search)
            ->latest()
            ->paginate();

        return new ProductGroupCollection($productGroups);
    }

    /**
     * @param \App\Http\Requests\ProductGroupStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductGroupStoreRequest $request)
    {
        $this->authorize('create', ProductGroup::class);

        $validated = $request->validated();

        $productGroup = ProductGroup::create($validated);

        return new ProductGroupResource($productGroup);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductGroup $productGroup
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ProductGroup $productGroup)
    {
        $this->authorize('view', $productGroup);

        return new ProductGroupResource($productGroup);
    }

    /**
     * @param \App\Http\Requests\ProductGroupUpdateRequest $request
     * @param \App\Models\ProductGroup $productGroup
     * @return \Illuminate\Http\Response
     */
    public function update(
        ProductGroupUpdateRequest $request,
        ProductGroup $productGroup
    ) {
        $this->authorize('update', $productGroup);

        $validated = $request->validated();

        $productGroup->update($validated);

        return new ProductGroupResource($productGroup);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductGroup $productGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ProductGroup $productGroup)
    {
        $this->authorize('delete', $productGroup);

        $productGroup->delete();

        return response()->noContent();
    }
}
