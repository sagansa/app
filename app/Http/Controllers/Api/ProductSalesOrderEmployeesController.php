<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\SalesOrderEmployee;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderEmployeeCollection;

class ProductSalesOrderEmployeesController extends Controller
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

        $salesOrderEmployees = $product
            ->salesOrderEmployees()
            ->search($search)
            ->latest()
            ->paginate();

        return new SalesOrderEmployeeCollection($salesOrderEmployees);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\SalesOrderEmployee $salesOrderEmployee
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Product $product,
        SalesOrderEmployee $salesOrderEmployee
    ) {
        $this->authorize('update', $product);

        $product
            ->salesOrderEmployees()
            ->syncWithoutDetaching([$salesOrderEmployee->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\SalesOrderEmployee $salesOrderEmployee
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Product $product,
        SalesOrderEmployee $salesOrderEmployee
    ) {
        $this->authorize('update', $product);

        $product->salesOrderEmployees()->detach($salesOrderEmployee);

        return response()->noContent();
    }
}
