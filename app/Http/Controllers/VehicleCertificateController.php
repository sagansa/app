<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\VehicleCertificate;
use Illuminate\Support\Facades\Auth;
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
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.vehicle_certificates.index',
            compact('vehicleCertificates', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $vehicles = Vehicle::orderBy('no_register', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('no_register', 'id');

        return view('app.vehicle_certificates.create', compact('vehicles'));
    }

    /**
     * @param \App\Http\Requests\VehicleCertificateStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(VehicleCertificateStoreRequest $request)
    {
        $this->authorize('create', VehicleCertificate::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $vehicleCertificate = VehicleCertificate::create($validated);

        return redirect()
            ->route('vehicle-certificates.edit', $vehicleCertificate)
            ->withSuccess(__('crud.common.created'));
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

        return view(
            'app.vehicle_certificates.show',
            compact('vehicleCertificate')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\VehicleCertificate $vehicleCertificate
     * @return \Illuminate\Http\Response
     */
    public function edit(
        Request $request,
        VehicleCertificate $vehicleCertificate
    ) {
        $this->authorize('update', $vehicleCertificate);

        $vehicles = Vehicle::orderBy('no_register', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('no_register', 'id');

        return view(
            'app.vehicle_certificates.edit',
            compact('vehicleCertificate', 'vehicles')
        );
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

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $vehicleCertificate->update($validated);

        return redirect()
            ->route('vehicle-certificates.index')
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('vehicle-certificates.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
