<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SelfConsumption;
use App\Http\Controllers\Controller;
use App\Http\Resources\SelfConsumptionResource;
use App\Http\Resources\SelfConsumptionCollection;
use App\Http\Requests\SelfConsumptionStoreRequest;
use App\Http\Requests\SelfConsumptionUpdateRequest;

class SelfConsumptionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', SelfConsumption::class);

        $search = $request->get('search', '');

        $selfConsumptions = SelfConsumption::search($search)
            ->latest()
            ->paginate();

        return new SelfConsumptionCollection($selfConsumptions);
    }

    /**
     * @param \App\Http\Requests\SelfConsumptionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SelfConsumptionStoreRequest $request)
    {
        $this->authorize('create', SelfConsumption::class);

        $validated = $request->validated();

        $selfConsumption = SelfConsumption::create($validated);

        return new SelfConsumptionResource($selfConsumption);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SelfConsumption $selfConsumption
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SelfConsumption $selfConsumption)
    {
        $this->authorize('view', $selfConsumption);

        return new SelfConsumptionResource($selfConsumption);
    }

    /**
     * @param \App\Http\Requests\SelfConsumptionUpdateRequest $request
     * @param \App\Models\SelfConsumption $selfConsumption
     * @return \Illuminate\Http\Response
     */
    public function update(
        SelfConsumptionUpdateRequest $request,
        SelfConsumption $selfConsumption
    ) {
        $this->authorize('update', $selfConsumption);

        $validated = $request->validated();

        $selfConsumption->update($validated);

        return new SelfConsumptionResource($selfConsumption);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SelfConsumption $selfConsumption
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SelfConsumption $selfConsumption)
    {
        $this->authorize('delete', $selfConsumption);

        $selfConsumption->delete();

        return response()->noContent();
    }
}
