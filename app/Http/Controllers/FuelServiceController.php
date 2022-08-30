<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Vehicle;
use App\Models\FuelService;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Models\ClosingStore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.fuel_services.index',
            compact('fuelServices', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $vehicles = Vehicle::orderBy('image', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('image', 'id');
        $paymentTypes = PaymentType::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $closingStores = ClosingStore::orderBy('date', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('date', 'id');

        return view(
            'app.fuel_services.create',
            compact('vehicles', 'paymentTypes', 'closingStores')
        );
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

        $fuelService = FuelService::create($validated);

        return redirect()
            ->route('fuel-services.edit', $fuelService)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FuelService $fuelService
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FuelService $fuelService)
    {
        $this->authorize('view', $fuelService);

        return view('app.fuel_services.show', compact('fuelService'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FuelService $fuelService
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, FuelService $fuelService)
    {
        $this->authorize('update', $fuelService);

        $vehicles = Vehicle::orderBy('image', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('image', 'id');
        $paymentTypes = PaymentType::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $closingStores = ClosingStore::orderBy('date', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('date', 'id');

        return view(
            'app.fuel_services.edit',
            compact('fuelService', 'vehicles', 'paymentTypes', 'closingStores')
        );
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
            $file = $request->file('image');
            $fuelService->delete_image();
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

        $fuelService->update($validated);

        return redirect()
            ->route('fuel-services.index')
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('fuel-services.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
