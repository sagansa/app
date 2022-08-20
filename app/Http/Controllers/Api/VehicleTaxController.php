<?php

namespace App\Http\Controllers\Api;

use App\Models\VehicleTax;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\VehicleTaxResource;
use App\Http\Resources\VehicleTaxCollection;
use App\Http\Requests\VehicleTaxStoreRequest;
use App\Http\Requests\VehicleTaxUpdateRequest;

class VehicleTaxController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', VehicleTax::class);

        $search = $request->get('search', '');

        $vehicleTaxes = VehicleTax::search($search)
            ->latest()
            ->paginate();

        return new VehicleTaxCollection($vehicleTaxes);
    }

    /**
     * @param \App\Http\Requests\VehicleTaxStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(VehicleTaxStoreRequest $request)
    {
        $this->authorize('create', VehicleTax::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $vehicleTax = VehicleTax::create($validated);

        return new VehicleTaxResource($vehicleTax);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\VehicleTax $vehicleTax
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, VehicleTax $vehicleTax)
    {
        $this->authorize('view', $vehicleTax);

        return new VehicleTaxResource($vehicleTax);
    }

    /**
     * @param \App\Http\Requests\VehicleTaxUpdateRequest $request
     * @param \App\Models\VehicleTax $vehicleTax
     * @return \Illuminate\Http\Response
     */
    public function update(
        VehicleTaxUpdateRequest $request,
        VehicleTax $vehicleTax
    ) {
        $this->authorize('update', $vehicleTax);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($vehicleTax->image) {
                Storage::delete($vehicleTax->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $vehicleTax->update($validated);

        return new VehicleTaxResource($vehicleTax);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\VehicleTax $vehicleTax
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, VehicleTax $vehicleTax)
    {
        $this->authorize('delete', $vehicleTax);

        if ($vehicleTax->image) {
            Storage::delete($vehicleTax->image);
        }

        $vehicleTax->delete();

        return response()->noContent();
    }
}
