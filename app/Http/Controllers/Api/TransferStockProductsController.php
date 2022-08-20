<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\TransferStock;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;

class TransferStockProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferStock $transferStock
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TransferStock $transferStock)
    {
        $this->authorize('view', $transferStock);

        $search = $request->get('search', '');

        $products = $transferStock
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferStock $transferStock
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        TransferStock $transferStock,
        Product $product
    ) {
        $this->authorize('update', $transferStock);

        $transferStock->products()->syncWithoutDetaching([$product->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferStock $transferStock
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        TransferStock $transferStock,
        Product $product
    ) {
        $this->authorize('update', $transferStock);

        $transferStock->products()->detach($product);

        return response()->noContent();
    }
}
