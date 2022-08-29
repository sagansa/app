<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use App\Models\DeliveryService;
use Illuminate\Support\Facades\Auth;
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
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.delivery_services.index',
            compact('deliveryServices', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.delivery_services.create');
    }

    /**
     * @param \App\Http\Requests\DeliveryServiceStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryServiceStoreRequest $request)
    {
        $this->authorize('create', DeliveryService::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $deliveryService = DeliveryService::create($validated);

        return redirect()
            ->route('delivery-services.edit', $deliveryService)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DeliveryService $deliveryService
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, DeliveryService $deliveryService)
    {
        $this->authorize('view', $deliveryService);

        return view('app.delivery_services.show', compact('deliveryService'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DeliveryService $deliveryService
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, DeliveryService $deliveryService)
    {
        $this->authorize('update', $deliveryService);

        return view('app.delivery_services.edit', compact('deliveryService'));
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

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $deliveryService->update($validated);

        return redirect()
            ->route('delivery-services.index')
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('delivery-services.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
