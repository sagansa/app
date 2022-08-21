<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Unit;
use App\Models\Store;
use App\Models\Utility;
use Illuminate\Http\Request;
use App\Models\UtilityProvider;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UtilityStoreRequest;
use App\Http\Requests\UtilityUpdateRequest;

class UtilityController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Utility::class);

        $search = $request->get('search', '');

        $utilities = Utility::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.utilities.index', compact('utilities', 'search'));
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
        $units = Unit::orderBy('unit', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('unit', 'id');
        $utilityProviders = UtilityProvider::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.utilities.create',
            compact('stores', 'units', 'utilityProviders')
        );
    }

    /**
     * @param \App\Http\Requests\UtilityStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UtilityStoreRequest $request)
    {
        $this->authorize('create', Utility::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $utility = Utility::create($validated);

        return redirect()
            ->route('utilities.edit', $utility)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Utility $utility
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Utility $utility)
    {
        $this->authorize('view', $utility);

        return view('app.utilities.show', compact('utility'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Utility $utility
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Utility $utility)
    {
        $this->authorize('update', $utility);

        $stores = Store::orderBy('name', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('name', 'id');
        $units = Unit::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $utilityProviders = UtilityProvider::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.utilities.edit',
            compact('utility', 'stores', 'units', 'utilityProviders')
        );
    }

    /**
     * @param \App\Http\Requests\UtilityUpdateRequest $request
     * @param \App\Models\Utility $utility
     * @return \Illuminate\Http\Response
     */
    public function update(UtilityUpdateRequest $request, Utility $utility)
    {
        $this->authorize('update', $utility);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $utility->update($validated);

        return redirect()
            ->route('utilities.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Utility $utility
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Utility $utility)
    {
        $this->authorize('delete', $utility);

        $utility->delete();

        return redirect()
            ->route('utilities.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
