<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\RemainingStock;
use App\Http\Controllers\Controller;
use App\Http\Resources\RemainingStockCollection;

class ProductRemainingStocksController extends Controller
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

        $remainingStocks = $product
            ->remainingStocks()
            ->search($search)
            ->latest()
            ->paginate();

        return new RemainingStockCollection($remainingStocks);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\RemainingStock $remainingStock
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Product $product,
        RemainingStock $remainingStock
    ) {
        $this->authorize('update', $product);

        $product
            ->remainingStocks()
            ->syncWithoutDetaching([$remainingStock->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\RemainingStock $remainingStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Product $product,
        RemainingStock $remainingStock
    ) {
        $this->authorize('update', $product);

        $product->remainingStocks()->detach($remainingStock);

        return response()->noContent();
    }
}
