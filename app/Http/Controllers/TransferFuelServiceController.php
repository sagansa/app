<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use App\Models\TransferFuelService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.transfer_fuel_services.index',
            compact('transferFuelServices', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.transfer_fuel_services.create');
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

        $transferFuelService = TransferFuelService::create($validated);

        return redirect()
            ->route('transfer-fuel-services.edit', $transferFuelService)
            ->withSuccess(__('crud.common.created'));
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

        return view(
            'app.transfer_fuel_services.show',
            compact('transferFuelService')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferFuelService $transferFuelService
     * @return \Illuminate\Http\Response
     */
    public function edit(
        Request $request,
        TransferFuelService $transferFuelService
    ) {
        $this->authorize('update', $transferFuelService);

        return view(
            'app.transfer_fuel_services.edit',
            compact('transferFuelService')
        );
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
            $file = $request->file('image');
            $transferFuelService->delete_image();
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

        $transferFuelService->update($validated);

        return redirect()
            ->route('transfer-fuel-services.index')
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('transfer-fuel-services.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
