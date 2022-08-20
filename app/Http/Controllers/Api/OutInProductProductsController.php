<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\OutInProduct;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;

class OutInProductProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OutInProduct $outInProduct
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, OutInProduct $outInProduct)
    {
        $this->authorize('view', $outInProduct);

        $search = $request->get('search', '');

        $products = $outInProduct
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OutInProduct $outInProduct
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        OutInProduct $outInProduct,
        Product $product
    ) {
        $this->authorize('update', $outInProduct);

        $outInProduct->products()->syncWithoutDetaching([$product->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OutInProduct $outInProduct
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        OutInProduct $outInProduct,
        Product $product
    ) {
        $this->authorize('update', $outInProduct);

        $outInProduct->products()->detach($product);

        return response()->noContent();
    }
}
