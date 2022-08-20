<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\RemainingStock;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;

class RemainingStockProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RemainingStock $remainingStock
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, RemainingStock $remainingStock)
    {
        $this->authorize('view', $remainingStock);

        $search = $request->get('search', '');

        $products = $remainingStock
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RemainingStock $remainingStock
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        RemainingStock $remainingStock,
        Product $product
    ) {
        $this->authorize('update', $remainingStock);

        $remainingStock->products()->syncWithoutDetaching([$product->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RemainingStock $remainingStock
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        RemainingStock $remainingStock,
        Product $product
    ) {
        $this->authorize('update', $remainingStock);

        $remainingStock->products()->detach($product);

        return response()->noContent();
    }
}
