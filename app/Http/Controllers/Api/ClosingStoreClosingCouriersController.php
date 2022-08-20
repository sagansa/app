<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ClosingStore;
use App\Models\ClosingCourier;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingCourierCollection;

class ClosingStoreClosingCouriersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ClosingStore $closingStore)
    {
        $this->authorize('view', $closingStore);

        $search = $request->get('search', '');

        $closingCouriers = $closingStore
            ->closingCouriers()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingCourierCollection($closingCouriers);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @param \App\Models\ClosingCourier $closingCourier
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        ClosingStore $closingStore,
        ClosingCourier $closingCourier
    ) {
        $this->authorize('update', $closingStore);

        $closingStore
            ->closingCouriers()
            ->syncWithoutDetaching([$closingCourier->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @param \App\Models\ClosingCourier $closingCourier
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        ClosingStore $closingStore,
        ClosingCourier $closingCourier
    ) {
        $this->authorize('update', $closingStore);

        $closingStore->closingCouriers()->detach($closingCourier);

        return response()->noContent();
    }
}
