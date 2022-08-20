<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\VehicleCertificate;
use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleCertificateResource;
use App\Http\Resources\VehicleCertificateCollection;
use App\Http\Requests\VehicleCertificateStoreRequest;
use App\Http\Requests\VehicleCertificateUpdateRequest;

class VehicleCertificateController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', VehicleCertificate::class);

        $search = $request->get('search', '');

        $vehicleCertificates = VehicleCertificate::search($search)
            ->latest()
            ->paginate();

        return new VehicleCertificateCollection($vehicleCertificates);
    }

    /**
     * @param \App\Http\Requests\VehicleCertificateStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(VehicleCertificateStoreRequest $request)
    {
        $this->authorize('create', VehicleCertificate::class);

        $validated = $request->validated();

        $vehicleCertificate = VehicleCertificate::create($validated);

        return new VehicleCertificateResource($vehicleCertificate);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\VehicleCertificate $vehicleCertificate
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        VehicleCertificate $vehicleCertificate
    ) {
        $this->authorize('view', $vehicleCertificate);

        return new VehicleCertificateResource($vehicleCertificate);
    }

    /**
     * @param \App\Http\Requests\VehicleCertificateUpdateRequest $request
     * @param \App\Models\VehicleCertificate $vehicleCertificate
     * @return \Illuminate\Http\Response
     */
    public function update(
        VehicleCertificateUpdateRequest $request,
        VehicleCertificate $vehicleCertificate
    ) {
        $this->authorize('update', $vehicleCertificate);

        $validated = $request->validated();

        $vehicleCertificate->update($validated);

        return new VehicleCertificateResource($vehicleCertificate);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\VehicleCertificate $vehicleCertificate
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        VehicleCertificate $vehicleCertificate
    ) {
        $this->authorize('delete', $vehicleCertificate);

        $vehicleCertificate->delete();

        return response()->noContent();
    }
}
