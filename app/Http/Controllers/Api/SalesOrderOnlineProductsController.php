<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\SalesOrderOnline;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;

class SalesOrderOnlineProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SalesOrderOnline $salesOrderOnline
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SalesOrderOnline $salesOrderOnline)
    {
        $this->authorize('view', $salesOrderOnline);

        $search = $request->get('search', '');

        $products = $salesOrderOnline
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SalesOrderOnline $salesOrderOnline
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        SalesOrderOnline $salesOrderOnline,
        Product $product
    ) {
        $this->authorize('update', $salesOrderOnline);

        $salesOrderOnline->products()->syncWithoutDetaching([$product->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SalesOrderOnline $salesOrderOnline
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        SalesOrderOnline $salesOrderOnline,
        Product $product
    ) {
        $this->authorize('update', $salesOrderOnline);

        $salesOrderOnline->products()->detach($product);

        return response()->noContent();
    }
}
