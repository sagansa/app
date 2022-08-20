<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Vehicle;
use App\Models\VehicleTax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            ->orderBy('expired_date', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.vehicle_taxes.index',
            compact('vehicleTaxes', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $vehicles = Vehicle::orderBy('no_register', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('no_register', 'id');

        return view('app.vehicle_taxes.create', compact('vehicles'));
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
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileimage = rand() . time() . '.' . $extension;
            $file->move('storage/', $fileimage);
            Image::make('storage/' . $fileimage)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image'] = $fileimage;
        }

        $validated['user_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $vehicleTax = VehicleTax::create($validated);

        return redirect()
            ->route('vehicle-taxes.edit', $vehicleTax)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\VehicleTax $vehicleTax
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, VehicleTax $vehicleTax)
    {
        $this->authorize('view', $vehicleTax);

        return view('app.vehicle_taxes.show', compact('vehicleTax'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\VehicleTax $vehicleTax
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, VehicleTax $vehicleTax)
    {
        $this->authorize('update', $vehicleTax);

        $vehicles = Vehicle::orderBy('no_register', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('no_register', 'id');

        return view(
            'app.vehicle_taxes.edit',
            compact('vehicleTax', 'vehicles')
        );
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
            $file = $request->file('image');
            $vehicleTax->delete_image();
            $extension = $file->getClientOriginalExtension();
            $file_image = rand() . time() . '.' . $extension;
            $file->move('storage/', $file_image);
            Image::make('storage/' . $file_image)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image'] = $file_image;
        }

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $vehicleTax->update($validated);

        return redirect()
            ->route('vehicle-taxes.index')
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('vehicle-taxes.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
