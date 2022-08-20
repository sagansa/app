<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Store;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\VehicleStoreRequest;
use App\Http\Requests\VehicleUpdateRequest;

class VehicleController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Vehicle::class);

        $search = $request->get('search', '');

        $vehicles = Vehicle::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.vehicles.index', compact('vehicles', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $stores = Store::orderBy('nickname', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('nickname', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view('app.vehicles.create', compact('stores', 'users'));
    }

    /**
     * @param \App\Http\Requests\VehicleStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(VehicleStoreRequest $request)
    {
        $this->authorize('create', Vehicle::class);

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

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $vehicle = Vehicle::create($validated);

        return redirect()
            ->route('vehicles.edit', $vehicle)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Vehicle $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Vehicle $vehicle)
    {
        $this->authorize('view', $vehicle);

        return view('app.vehicles.show', compact('vehicle'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Vehicle $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle);

        $stores = Store::orderBy('nickname', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('nickname', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view('app.vehicles.edit', compact('vehicle', 'stores', 'users'));
    }

    /**
     * @param \App\Http\Requests\VehicleUpdateRequest $request
     * @param \App\Models\Vehicle $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(VehicleUpdateRequest $request, Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $vehicle->delete_image();
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

        $vehicle->update($validated);

        return redirect()
            ->route('vehicles.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Vehicle $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Vehicle $vehicle)
    {
        $this->authorize('delete', $vehicle);

        if ($vehicle->image) {
            Storage::delete($vehicle->image);
        }

        $vehicle->delete();

        return redirect()
            ->route('vehicles.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
