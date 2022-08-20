<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\OutInProduct;
use App\Http\Controllers\Controller;
use App\Http\Resources\OutInProductCollection;

class ProductOutInProductsController extends Controller
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

        $outInProducts = $product
            ->outInProducts()
            ->search($search)
            ->latest()
            ->paginate();

        return new OutInProductCollection($outInProducts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\OutInProduct $outInProduct
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Product $product,
        OutInProduct $outInProduct
    ) {
        $this->authorize('update', $product);

        $product->outInProducts()->syncWithoutDetaching([$outInProduct->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\OutInProduct $outInProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Product $product,
        OutInProduct $outInProduct
    ) {
        $this->authorize('update', $product);

        $product->outInProducts()->detach($outInProduct);

        return response()->noContent();
    }
}
