<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ClosingStore;
use App\Models\ClosingCourier;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingStoreCollection;

class ClosingCourierClosingStoresController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingCourier $closingCourier
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ClosingCourier $closingCourier)
    {
        $this->authorize('view', $closingCourier);

        $search = $request->get('search', '');

        $closingStores = $closingCourier
            ->closingStores()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingStoreCollection($closingStores);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingCourier $closingCourier
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        ClosingCourier $closingCourier,
        ClosingStore $closingStore
    ) {
        $this->authorize('update', $closingCourier);

        $closingCourier
            ->closingStores()
            ->syncWithoutDetaching([$closingStore->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingCourier $closingCourier
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        ClosingCourier $closingCourier,
        ClosingStore $closingStore
    ) {
        $this->authorize('update', $closingCourier);

        $closingCourier->closingStores()->detach($closingStore);

        return response()->noContent();
    }
}
