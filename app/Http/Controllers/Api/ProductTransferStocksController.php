<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\TransferStock;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransferStockCollection;

class ProductTransferStocksController extends Controller
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

        $transferStocks = $product
            ->transferStocks()
            ->search($search)
            ->latest()
            ->paginate();

        return new TransferStockCollection($transferStocks);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\TransferStock $transferStock
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Product $product,
        TransferStock $transferStock
    ) {
        $this->authorize('update', $product);

        $product->transferStocks()->syncWithoutDetaching([$transferStock->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\TransferStock $transferStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Product $product,
        TransferStock $transferStock
    ) {
        $this->authorize('update', $product);

        $product->transferStocks()->detach($transferStock);

        return response()->noContent();
    }
}
