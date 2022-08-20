<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\CashlessProvider;
use App\Http\Controllers\Controller;
use App\Http\Resources\CashlessProviderResource;
use App\Http\Resources\CashlessProviderCollection;
use App\Http\Requests\CashlessProviderStoreRequest;
use App\Http\Requests\CashlessProviderUpdateRequest;

class CashlessProviderController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', CashlessProvider::class);

        $search = $request->get('search', '');

        $cashlessProviders = CashlessProvider::search($search)
            ->latest()
            ->paginate();

        return new CashlessProviderCollection($cashlessProviders);
    }

    /**
     * @param \App\Http\Requests\CashlessProviderStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CashlessProviderStoreRequest $request)
    {
        $this->authorize('create', CashlessProvider::class);

        $validated = $request->validated();

        $cashlessProvider = CashlessProvider::create($validated);

        return new CashlessProviderResource($cashlessProvider);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashlessProvider $cashlessProvider
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, CashlessProvider $cashlessProvider)
    {
        $this->authorize('view', $cashlessProvider);

        return new CashlessProviderResource($cashlessProvider);
    }

    /**
     * @param \App\Http\Requests\CashlessProviderUpdateRequest $request
     * @param \App\Models\CashlessProvider $cashlessProvider
     * @return \Illuminate\Http\Response
     */
    public function update(
        CashlessProviderUpdateRequest $request,
        CashlessProvider $cashlessProvider
    ) {
        $this->authorize('update', $cashlessProvider);

        $validated = $request->validated();

        $cashlessProvider->update($validated);

        return new CashlessProviderResource($cashlessProvider);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashlessProvider $cashlessProvider
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        CashlessProvider $cashlessProvider
    ) {
        $this->authorize('delete', $cashlessProvider);

        $cashlessProvider->delete();

        return response()->noContent();
    }
}
