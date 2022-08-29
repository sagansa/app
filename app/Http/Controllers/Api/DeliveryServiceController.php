<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\DeliveryService;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryServiceResource;
use App\Http\Resources\DeliveryServiceCollection;
use App\Http\Requests\DeliveryServiceStoreRequest;
use App\Http\Requests\DeliveryServiceUpdateRequest;

class DeliveryServiceController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', DeliveryService::class);

        $search = $request->get('search', '');

        $deliveryServices = DeliveryService::search($search)
            ->latest()
            ->paginate();

        return new DeliveryServiceCollection($deliveryServices);
    }

    /**
     * @param \App\Http\Requests\DeliveryServiceStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryServiceStoreRequest $request)
    {
        $this->authorize('create', DeliveryService::class);

        $validated = $request->validated();

        $deliveryService = DeliveryService::create($validated);

        return new DeliveryServiceResource($deliveryService);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DeliveryService $deliveryService
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DeliveryService $deliveryService)
    {
        $this->authorize('view', $deliveryService);

        return new DeliveryServiceResource($deliveryService);
    }

    /**
     * @param \App\Http\Requests\DeliveryServiceUpdateRequest $request
     * @param \App\Models\DeliveryService $deliveryService
     * @return \Illuminate\Http\Response
     */
    public function update(
        DeliveryServiceUpdateRequest $request,
        DeliveryService $deliveryService
    ) {
        $this->authorize('update', $deliveryService);

        $validated = $request->validated();

        $deliveryService->update($validated);

        return new DeliveryServiceResource($deliveryService);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DeliveryService $deliveryService
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DeliveryService $deliveryService)
    {
        $this->authorize('delete', $deliveryService);

        $deliveryService->delete();

        return response()->noContent();
    }
}
