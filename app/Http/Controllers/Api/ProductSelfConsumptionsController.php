<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\SelfConsumption;
use App\Http\Controllers\Controller;
use App\Http\Resources\SelfConsumptionCollection;

class ProductSelfConsumptionsController extends Controller
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

        $selfConsumptions = $product
            ->selfConsumptions()
            ->search($search)
            ->latest()
            ->paginate();

        return new SelfConsumptionCollection($selfConsumptions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\SelfConsumption $selfConsumption
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Product $product,
        SelfConsumption $selfConsumption
    ) {
        $this->authorize('update', $product);

        $product
            ->selfConsumptions()
            ->syncWithoutDetaching([$selfConsumption->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\SelfConsumption $selfConsumption
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Product $product,
        SelfConsumption $selfConsumption
    ) {
        $this->authorize('update', $product);

        $product->selfConsumptions()->detach($selfConsumption);

        return response()->noContent();
    }
}
