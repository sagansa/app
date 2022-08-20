<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\SalesOrderOnline;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderOnlineCollection;

class ProductSalesOrderOnlinesController extends Controller
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

        $salesOrderOnlines = $product
            ->salesOrderOnlines()
            ->search($search)
            ->latest()
            ->paginate();

        return new SalesOrderOnlineCollection($salesOrderOnlines);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\SalesOrderOnline $salesOrderOnline
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Product $product,
        SalesOrderOnline $salesOrderOnline
    ) {
        $this->authorize('update', $product);

        $product
            ->salesOrderOnlines()
            ->syncWithoutDetaching([$salesOrderOnline->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\SalesOrderOnline $salesOrderOnline
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Product $product,
        SalesOrderOnline $salesOrderOnline
    ) {
        $this->authorize('update', $product);

        $product->salesOrderOnlines()->detach($salesOrderOnline);

        return response()->noContent();
    }
}
