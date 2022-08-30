<?php

namespace App\Http\Controllers\Api;

use App\Models\FuelService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\FuelServiceResource;
use App\Http\Resources\FuelServiceCollection;
use App\Http\Requests\FuelServiceStoreRequest;
use App\Http\Requests\FuelServiceUpdateRequest;

class FuelServiceController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', FuelService::class);

        $search = $request->get('search', '');

        $fuelServices = FuelService::search($search)
            ->latest()
            ->paginate();

        return new FuelServiceCollection($fuelServices);
    }

    /**
     * @param \App\Http\Requests\FuelServiceStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FuelServiceStoreRequest $request)
    {
        $this->authorize('create', FuelService::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $fuelService = FuelService::create($validated);

        return new FuelServiceResource($fuelService);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FuelService $fuelService
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FuelService $fuelService)
    {
        $this->authorize('view', $fuelService);

        return new FuelServiceResource($fuelService);
    }

    /**
     * @param \App\Http\Requests\FuelServiceUpdateRequest $request
     * @param \App\Models\FuelService $fuelService
     * @return \Illuminate\Http\Response
     */
    public function update(
        FuelServiceUpdateRequest $request,
        FuelService $fuelService
    ) {
        $this->authorize('update', $fuelService);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($fuelService->image) {
                Storage::delete($fuelService->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $fuelService->update($validated);

        return new FuelServiceResource($fuelService);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FuelService $fuelService
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, FuelService $fuelService)
    {
        $this->authorize('delete', $fuelService);

        if ($fuelService->image) {
            Storage::delete($fuelService->image);
        }

        $fuelService->delete();

        return response()->noContent();
    }
}
