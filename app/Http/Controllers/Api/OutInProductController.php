<?php

namespace App\Http\Controllers\Api;

use App\Models\OutInProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\OutInProductResource;
use App\Http\Resources\OutInProductCollection;
use App\Http\Requests\OutInProductStoreRequest;
use App\Http\Requests\OutInProductUpdateRequest;

class OutInProductController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', OutInProduct::class);

        $search = $request->get('search', '');

        $outInProducts = OutInProduct::search($search)
            ->latest()
            ->paginate();

        return new OutInProductCollection($outInProducts);
    }

    /**
     * @param \App\Http\Requests\OutInProductStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OutInProductStoreRequest $request)
    {
        $this->authorize('create', OutInProduct::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $outInProduct = OutInProduct::create($validated);

        return new OutInProductResource($outInProduct);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OutInProduct $outInProduct
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, OutInProduct $outInProduct)
    {
        $this->authorize('view', $outInProduct);

        return new OutInProductResource($outInProduct);
    }

    /**
     * @param \App\Http\Requests\OutInProductUpdateRequest $request
     * @param \App\Models\OutInProduct $outInProduct
     * @return \Illuminate\Http\Response
     */
    public function update(
        OutInProductUpdateRequest $request,
        OutInProduct $outInProduct
    ) {
        $this->authorize('update', $outInProduct);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($outInProduct->image) {
                Storage::delete($outInProduct->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $outInProduct->update($validated);

        return new OutInProductResource($outInProduct);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OutInProduct $outInProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, OutInProduct $outInProduct)
    {
        $this->authorize('delete', $outInProduct);

        if ($outInProduct->image) {
            Storage::delete($outInProduct->image);
        }

        $outInProduct->delete();

        return response()->noContent();
    }
}
