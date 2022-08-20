<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Store;
use App\Models\StoreAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAssetStoreRequest;
use App\Http\Requests\StoreAssetUpdateRequest;

class StoreAssetController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', StoreAsset::class);

        $search = $request->get('search', '');

        $storeAssets = StoreAsset::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.store_assets.index', compact('storeAssets', 'search'));
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

        return view('app.store_assets.create', compact('stores'));
    }

    /**
     * @param \App\Http\Requests\StoreAssetStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssetStoreRequest $request)
    {
        $this->authorize('create', StoreAsset::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $storeAsset = StoreAsset::create($validated);

        return redirect()
            ->route('store-assets.edit', $storeAsset)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StoreAsset $storeAsset
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, StoreAsset $storeAsset)
    {
        $this->authorize('view', $storeAsset);

        return view('app.store_assets.show', compact('storeAsset'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StoreAsset $storeAsset
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, StoreAsset $storeAsset)
    {
        $this->authorize('update', $storeAsset);

        $stores = Store::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view('app.store_assets.edit', compact('storeAsset', 'stores'));
    }

    /**
     * @param \App\Http\Requests\StoreAssetUpdateRequest $request
     * @param \App\Models\StoreAsset $storeAsset
     * @return \Illuminate\Http\Response
     */
    public function update(
        StoreAssetUpdateRequest $request,
        StoreAsset $storeAsset
    ) {
        $this->authorize('update', $storeAsset);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $storeAsset->update($validated);

        return redirect()
            ->route('store-assets.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StoreAsset $storeAsset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, StoreAsset $storeAsset)
    {
        $this->authorize('delete', $storeAsset);

        $storeAsset->delete();

        return redirect()
            ->route('store-assets.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
