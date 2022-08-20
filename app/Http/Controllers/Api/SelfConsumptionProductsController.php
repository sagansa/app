<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\SelfConsumption;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;

class SelfConsumptionProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SelfConsumption $selfConsumption
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SelfConsumption $selfConsumption)
    {
        $this->authorize('view', $selfConsumption);

        $search = $request->get('search', '');

        $products = $selfConsumption
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SelfConsumption $selfConsumption
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        SelfConsumption $selfConsumption,
        Product $product
    ) {
        $this->authorize('update', $selfConsumption);

        $selfConsumption->products()->syncWithoutDetaching([$product->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SelfConsumption $selfConsumption
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        SelfConsumption $selfConsumption,
        Product $product
    ) {
        $this->authorize('update', $selfConsumption);

        $selfConsumption->products()->detach($product);

        return response()->noContent();
    }
}
