<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Utility;
use App\Models\UtilityBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UtilityBillStoreRequest;
use App\Http\Requests\UtilityBillUpdateRequest;

class UtilityBillController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', UtilityBill::class);

        $search = $request->get('search', '');

        $utilityBills = UtilityBill::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.utility_bills.index',
            compact('utilityBills', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $utilities = Utility::orderBy('store_id', 'asc')
            ->whereIn('status', ['1'])
            ->get()
            ->pluck('utility_name', 'id');

        return view('app.utility_bills.create', compact('utilities'));
    }

    /**
     * @param \App\Http\Requests\UtilityBillStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UtilityBillStoreRequest $request)
    {
        $this->authorize('create', UtilityBill::class);

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

        $utilityBill = UtilityBill::create($validated);

        return redirect()
            ->route('utility-bills.edit', $utilityBill)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UtilityBill $utilityBill
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, UtilityBill $utilityBill)
    {
        $this->authorize('view', $utilityBill);

        return view('app.utility_bills.show', compact('utilityBill'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UtilityBill $utilityBill
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, UtilityBill $utilityBill)
    {
        $this->authorize('update', $utilityBill);

        $utilities = Utility::orderBy('store_id', 'asc')
            ->whereIn('status', ['1'])
            ->get()
            ->pluck('utility_name', 'id');

        return view(
            'app.utility_bills.edit',
            compact('utilityBill', 'utilities')
        );
    }

    /**
     * @param \App\Http\Requests\UtilityBillUpdateRequest $request
     * @param \App\Models\UtilityBill $utilityBill
     * @return \Illuminate\Http\Response
     */
    public function update(
        UtilityBillUpdateRequest $request,
        UtilityBill $utilityBill
    ) {
        $this->authorize('update', $utilityBill);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $utilityBill->delete_image();
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

        $utilityBill->update($validated);

        return redirect()
            ->route('utility-bills.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UtilityBill $utilityBill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, UtilityBill $utilityBill)
    {
        $this->authorize('delete', $utilityBill);

        if ($utilityBill->image) {
            Storage::delete($utilityBill->image);
        }

        $utilityBill->delete();

        return redirect()
            ->route('utility-bills.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
