<?php

namespace App\Http\Controllers\Api;

use App\Models\StoreAsset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MovementAssetResource;
use App\Http\Resources\MovementAssetCollection;

class StoreAssetMovementAssetsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StoreAsset $storeAsset
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, StoreAsset $storeAsset)
    {
        $this->authorize('view', $storeAsset);

        $search = $request->get('search', '');

        $movementAssets = $storeAsset
            ->movementAssets()
            ->search($search)
            ->latest()
            ->paginate();

        return new MovementAssetCollection($movementAssets);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StoreAsset $storeAsset
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, StoreAsset $storeAsset)
    {
        $this->authorize('create', MovementAsset::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'qr_code' => ['image', 'nullable'],
            'product_id' => ['required', 'exists:products,id'],
            'good_cond_qty' => ['required', 'numeric'],
            'bad_cond_qty' => ['required', 'numeric'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        if ($request->hasFile('qr_code')) {
            $validated['qr_code'] = $request->file('qr_code')->store('public');
        }

        $movementAsset = $storeAsset->movementAssets()->create($validated);

        return new MovementAssetResource($movementAsset);
    }
}
