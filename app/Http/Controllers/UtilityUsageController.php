<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Utility;
use App\Models\UtilityUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UtilityUsageStoreRequest;
use App\Http\Requests\UtilityUsageUpdateRequest;
use Illuminate\Support\Facades\DB;

class UtilityUsageController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', UtilityUsage::class);

        $search = $request->get('search', '');

        // $utilityUsages = UtilityUsage::search($search)
        //     ->latest()
        //     ->paginate(10)
        //     ->withQueryString();

        if(Auth::user()->hasRole('supervisor')) {
            $utilityUsages = UtilityUsage::search($search)
                ->where('approved_by_id', '=', Auth::user()->id)
                ->orWhere('approved_by_id', '=', NULL)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } elseif (Auth::user()->hasRole('super-admin|manager')) {
            $utilityUsages = UtilityUsage::search($search)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } else if (Auth::user()->hasRole('staff')) {
            $utilityUsages = UtilityUsage::search($search)
                ->where('created_by_id', '=', Auth::user()->id)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        return view(
            'app.utility_usages.index',
            compact('utilityUsages', 'search')
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
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.utility_usages.create',
            compact( 'utilities', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\UtilityUsageStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UtilityUsageStoreRequest $request)
    {
        $this->authorize('create', UtilityUsage::class);

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

        $utilityUsage = UtilityUsage::create($validated);

        return redirect()
            ->route('utility-usages.edit', $utilityUsage)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UtilityUsage $utilityUsage
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, UtilityUsage $utilityUsage)
    {
        $this->authorize('view', $utilityUsage);

        return view('app.utility_usages.show', compact('utilityUsage'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UtilityUsage $utilityUsage
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, UtilityUsage $utilityUsage)
    {
        $this->authorize('update', $utilityUsage);

        $utilities = Utility::orderBy('number', 'asc')
            ->whereIn('status', ['1'])
            ->get()
            ->pluck('utility_name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.utility_usages.edit',
            compact('utilityUsage', 'utilities', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\UtilityUsageUpdateRequest $request
     * @param \App\Models\UtilityUsage $utilityUsage
     * @return \Illuminate\Http\Response
     */
    public function update(
        UtilityUsageUpdateRequest $request,
        UtilityUsage $utilityUsage
    ) {
        $this->authorize('update', $utilityUsage);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $utilityUsage->delete_image();
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

        $utilityUsage->update($validated);

        return redirect()
            ->route('utility-usages.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UtilityUsage $utilityUsage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, UtilityUsage $utilityUsage)
    {
        $this->authorize('delete', $utilityUsage);

        if ($utilityUsage->image) {
            Storage::delete($utilityUsage->image);
        }

        $utilityUsage->delete();

        return redirect()
            ->route('utility-usages.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
