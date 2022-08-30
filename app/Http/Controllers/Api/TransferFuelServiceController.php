<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\TransferFuelService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\TransferFuelServiceResource;
use App\Http\Resources\TransferFuelServiceCollection;
use App\Http\Requests\TransferFuelServiceStoreRequest;
use App\Http\Requests\TransferFuelServiceUpdateRequest;

class TransferFuelServiceController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', TransferFuelService::class);

        $search = $request->get('search', '');

        $transferFuelServices = TransferFuelService::search($search)
            ->latest()
            ->paginate();

        return new TransferFuelServiceCollection($transferFuelServices);
    }

    /**
     * @param \App\Http\Requests\TransferFuelServiceStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransferFuelServiceStoreRequest $request)
    {
        $this->authorize('create', TransferFuelService::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $transferFuelService = TransferFuelService::create($validated);

        return new TransferFuelServiceResource($transferFuelService);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferFuelService $transferFuelService
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        TransferFuelService $transferFuelService
    ) {
        $this->authorize('view', $transferFuelService);

        return new TransferFuelServiceResource($transferFuelService);
    }

    /**
     * @param \App\Http\Requests\TransferFuelServiceUpdateRequest $request
     * @param \App\Models\TransferFuelService $transferFuelService
     * @return \Illuminate\Http\Response
     */
    public function update(
        TransferFuelServiceUpdateRequest $request,
        TransferFuelService $transferFuelService
    ) {
        $this->authorize('update', $transferFuelService);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($transferFuelService->image) {
                Storage::delete($transferFuelService->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $transferFuelService->update($validated);

        return new TransferFuelServiceResource($transferFuelService);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferFuelService $transferFuelService
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        TransferFuelService $transferFuelService
    ) {
        $this->authorize('delete', $transferFuelService);

        if ($transferFuelService->image) {
            Storage::delete($transferFuelService->image);
        }

        $transferFuelService->delete();

        return response()->noContent();
    }
}
