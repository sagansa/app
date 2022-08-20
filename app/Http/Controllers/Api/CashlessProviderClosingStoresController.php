<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ClosingStore;
use App\Models\CashlessProvider;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingStoreCollection;

class CashlessProviderClosingStoresController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashlessProvider $cashlessProvider
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CashlessProvider $cashlessProvider)
    {
        $this->authorize('view', $cashlessProvider);

        $search = $request->get('search', '');

        $closingStores = $cashlessProvider
            ->closingStores()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingStoreCollection($closingStores);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashlessProvider $cashlessProvider
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        CashlessProvider $cashlessProvider,
        ClosingStore $closingStore
    ) {
        $this->authorize('update', $cashlessProvider);

        $cashlessProvider
            ->closingStores()
            ->syncWithoutDetaching([$closingStore->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashlessProvider $cashlessProvider
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        CashlessProvider $cashlessProvider,
        ClosingStore $closingStore
    ) {
        $this->authorize('update', $cashlessProvider);

        $cashlessProvider->closingStores()->detach($closingStore);

        return response()->noContent();
    }
}
