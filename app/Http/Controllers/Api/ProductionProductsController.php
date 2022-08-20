<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Production;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;

class ProductionProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Production $production)
    {
        $this->authorize('view', $production);

        $search = $request->get('search', '');

        $products = $production
            ->from_support_products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Production $production
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Production $production,
        Product $product
    ) {
        $this->authorize('update', $production);

        $production
            ->from_support_products()
            ->syncWithoutDetaching([$product->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Production $production
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Production $production,
        Product $product
    ) {
        $this->authorize('update', $production);

        $production->from_support_products()->detach($product);

        return response()->noContent();
    }
}
