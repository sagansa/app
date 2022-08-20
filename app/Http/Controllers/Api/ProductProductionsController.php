<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Production;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductionCollection;

class ProductProductionsController extends Controller
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

        $productions = $product
            ->productions()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductionCollection($productions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Product $product,
        Production $production
    ) {
        $this->authorize('update', $product);

        $product->productions()->syncWithoutDetaching([$production->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Product $product,
        Production $production
    ) {
        $this->authorize('update', $product);

        $product->productions()->detach($production);

        return response()->noContent();
    }
}
