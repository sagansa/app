<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\MovementAsset;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\MovementAssetStoreRequest;
use App\Http\Requests\MovementAssetUpdateRequest;

class MovementAssetController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', MovementAsset::class);

        $search = $request->get('search', '');

        $movementAssets = MovementAsset::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.movement_assets.index',
            compact('movementAssets', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $stores = Store::orderBy('name', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('name', 'id');
        $products = Product::orderBy('name', 'asc')
            ->whereIn('material_group_id', ['8'])
            ->pluck('name', 'id');

        return view(
            'app.movement_assets.create',
            compact('stores', 'products')
        );
    }

    /**
     * @param \App\Http\Requests\MovementAssetStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MovementAssetStoreRequest $request)
    {
        $this->authorize('create', MovementAsset::class);

        $validated = $request->validated();

        if ($request->hasFile('qr_code')) {
            $file = $request->file('qr_code');
            $extension = $file->getClientOriginalExtension();
            $fileqr_code = rand() . time() . '.' . $extension;
            $file->move('storage/', $fileqr_code);
            Image::make('storage/' . $fileqr_code)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['qr_code'] = $fileqr_code;
        }

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $movementAsset = MovementAsset::create($validated);

        return redirect()
            ->route('movement-assets.edit', $movementAsset)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MovementAsset $movementAsset
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MovementAsset $movementAsset)
    {
        $this->authorize('view', $movementAsset);

        return view('app.movement_assets.show', compact('movementAsset'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MovementAsset $movementAsset
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, MovementAsset $movementAsset)
    {
        $this->authorize('update', $movementAsset);

        $stores = Store::orderBy('name', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('name', 'id');
        $products = Product::orderBy('name', 'asc')
            ->whereIn('material_group_id', ['8'])
            ->pluck('name', 'id');

        return view(
            'app.movement_assets.edit',
            compact('movementAsset', 'stores', 'products')
        );
    }

    /**
     * @param \App\Http\Requests\MovementAssetUpdateRequest $request
     * @param \App\Models\MovementAsset $movementAsset
     * @return \Illuminate\Http\Response
     */
    public function update(
        MovementAssetUpdateRequest $request,
        MovementAsset $movementAsset
    ) {
        $this->authorize('update', $movementAsset);

        $validated = $request->validated();
        if ($request->hasFile('qr_code')) {
            $file = $request->file('qr_code');
            $movementAsset->delete_qr_code();
            $extension = $file->getClientOriginalExtension();
            $file_qr_code = rand() . time() . '.' . $extension;
            $file->move('storage/', $file_qr_code);
            Image::make('storage/' . $file_qr_code)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['qr_code'] = $file_qr_code;
        }

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        if (
            auth()
                ->user()
                ->hasRole('staff') &&
            $validated['status'] == '3'
        ) {
            $validated['status'] = '4';
        }

        $movementAsset->update($validated);

        return redirect()
            ->route('movement-assets.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MovementAsset $movementAsset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, MovementAsset $movementAsset)
    {
        $this->authorize('delete', $movementAsset);

        if ($movementAsset->qr_code) {
            Storage::delete($movementAsset->qr_code);
        }

        $movementAsset->delete();

        return redirect()
            ->route('movement-assets.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
