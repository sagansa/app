<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\RequestStock;
use App\Http\Controllers\Controller;
use App\Http\Resources\RequestStockCollection;

class ProductRequestStocksController extends Controller
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

        $requestStocks = $product
            ->requestStocks()
            ->search($search)
            ->latest()
            ->paginate();

        return new RequestStockCollection($requestStocks);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\RequestStock $requestStock
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Product $product,
        RequestStock $requestStock
    ) {
        $this->authorize('update', $product);

        $product->requestStocks()->syncWithoutDetaching([$requestStock->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\RequestStock $requestStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Product $product,
        RequestStock $requestStock
    ) {
        $this->authorize('update', $product);

        $product->requestStocks()->detach($requestStock);

        return response()->noContent();
    }
}
