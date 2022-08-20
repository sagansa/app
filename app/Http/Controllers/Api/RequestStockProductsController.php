<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\RequestStock;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;

class RequestStockProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RequestStock $requestStock
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, RequestStock $requestStock)
    {
        $this->authorize('view', $requestStock);

        $search = $request->get('search', '');

        $products = $requestStock
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RequestStock $requestStock
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        RequestStock $requestStock,
        Product $product
    ) {
        $this->authorize('update', $requestStock);

        $requestStock->products()->syncWithoutDetaching([$product->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RequestStock $requestStock
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        RequestStock $requestStock,
        Product $product
    ) {
        $this->authorize('update', $requestStock);

        $requestStock->products()->detach($product);

        return response()->noContent();
    }
}
