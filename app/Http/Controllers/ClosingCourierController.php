<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\ClosingCourier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ClosingCourierStoreRequest;
use App\Http\Requests\ClosingCourierUpdateRequest;

class ClosingCourierController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ClosingCourier::class);

        $search = $request->get('search', '');

        // $closingCouriers = ClosingCourier::search($search)
        //     ->latest()
        //     ->paginate(10)
        //     ->withQueryString();

        if(Auth::user()->hasRole('supervisor')) {
            $closingCouriers = ClosingCourier::search($search)
                ->where('approved_by_id', '=', Auth::user()->id)
                ->orWhere('approved_by_id', '=', NULL)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } elseif (Auth::user()->hasRole('super-admin|manager')) {
            $closingCouriers = ClosingCourier::search($search)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } else if (Auth::user()->hasRole('staff')) {
            $closingCouriers = ClosingCourier::search($search)
                ->where('created_by_id', '=', Auth::user()->id)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        return view(
            'app.closing_couriers.index',
            compact('closingCouriers', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $banks = Bank::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view('app.closing_couriers.create', compact('banks'));
    }

    /**
     * @param \App\Http\Requests\ClosingCourierStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClosingCourierStoreRequest $request)
    {
        $this->authorize('create', ClosingCourier::class);

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

        $closingCourier = ClosingCourier::create($validated);

        return redirect()
            ->route('closing-couriers.edit', $closingCourier)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingCourier $closingCourier
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ClosingCourier $closingCourier)
    {
        $this->authorize('view', $closingCourier);

        return view('app.closing_couriers.show', compact('closingCourier'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingCourier $closingCourier
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ClosingCourier $closingCourier)
    {
        $this->authorize('update', $closingCourier);

        $banks = Bank::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.closing_couriers.edit',
            compact('closingCourier', 'banks')
        );
    }

    /**
     * @param \App\Http\Requests\ClosingCourierUpdateRequest $request
     * @param \App\Models\ClosingCourier $closingCourier
     * @return \Illuminate\Http\Response
     */
    public function update(
        ClosingCourierUpdateRequest $request,
        ClosingCourier $closingCourier
    ) {
        $this->authorize('update', $closingCourier);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $closingCourier->delete_image();
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

        $closingCourier->update($validated);

        return redirect()
            ->route('closing-couriers.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingCourier $closingCourier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ClosingCourier $closingCourier)
    {
        $this->authorize('delete', $closingCourier);

        if ($closingCourier->image) {
            Storage::delete($closingCourier->image);
        }

        $closingCourier->delete();

        return redirect()
            ->route('closing-couriers.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
