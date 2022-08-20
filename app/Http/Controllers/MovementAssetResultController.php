<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\MovementAssetResult;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MovementAssetResultStoreRequest;
use App\Http\Requests\MovementAssetResultUpdateRequest;

class MovementAssetResultController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', MovementAssetResult::class);

        $search = $request->get('search', '');

        $movementAssetResults = MovementAssetResult::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.movement_asset_results.index',
            compact('movementAssetResults', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $stores = Store::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.movement_asset_results.create',
            compact('stores', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\MovementAssetResultStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MovementAssetResultStoreRequest $request)
    {
        $this->authorize('create', MovementAssetResult::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $movementAssetResult = MovementAssetResult::create($validated);

        return redirect()
            ->route('movement-asset-results.edit', $movementAssetResult)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MovementAssetResult $movementAssetResult
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        MovementAssetResult $movementAssetResult
    ) {
        $this->authorize('view', $movementAssetResult);

        return view(
            'app.movement_asset_results.show',
            compact('movementAssetResult')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MovementAssetResult $movementAssetResult
     * @return \Illuminate\Http\Response
     */
    public function edit(
        Request $request,
        MovementAssetResult $movementAssetResult
    ) {
        $this->authorize('update', $movementAssetResult);

        $stores = Store::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.movement_asset_results.edit',
            compact('movementAssetResult', 'stores', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\MovementAssetResultUpdateRequest $request
     * @param \App\Models\MovementAssetResult $movementAssetResult
     * @return \Illuminate\Http\Response
     */
    public function update(
        MovementAssetResultUpdateRequest $request,
        MovementAssetResult $movementAssetResult
    ) {
        $this->authorize('update', $movementAssetResult);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $movementAssetResult->update($validated);

        return redirect()
            ->route('movement-asset-results.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MovementAssetResult $movementAssetResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        MovementAssetResult $movementAssetResult
    ) {
        $this->authorize('delete', $movementAssetResult);

        $movementAssetResult->delete();

        return redirect()
            ->route('movement-asset-results.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
