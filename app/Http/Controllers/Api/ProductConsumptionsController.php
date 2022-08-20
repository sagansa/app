<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Consumption;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConsumptionCollection;

class ProductConsumptionsController extends Controller
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

        $consumptions = $product
            ->consumptions()
            ->search($search)
            ->latest()
            ->paginate();

        return new ConsumptionCollection($consumptions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\Consumption $consumption
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Product $product,
        Consumption $consumption
    ) {
        $this->authorize('update', $product);

        $product->consumptions()->syncWithoutDetaching([$consumption->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\Consumption $consumption
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Product $product,
        Consumption $consumption
    ) {
        $this->authorize('update', $product);

        $product->consumptions()->detach($consumption);

        return response()->noContent();
    }
}
