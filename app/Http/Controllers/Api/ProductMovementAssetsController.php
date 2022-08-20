<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MovementAssetResource;
use App\Http\Resources\MovementAssetCollection;

class ProductMovementAssetsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Product $product)
    {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $movementAssets = $product
            ->movementAssets()
            ->search($search)
            ->latest()
            ->paginate();

        return new MovementAssetCollection($movementAssets);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $this->authorize('create', MovementAsset::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'qr_code' => ['image', 'nullable'],
            'good_cond_qty' => ['required', 'numeric'],
            'bad_cond_qty' => ['required', 'numeric'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        if ($request->hasFile('qr_code')) {
            $validated['qr_code'] = $request->file('qr_code')->store('public');
        }

        $movementAsset = $product->movementAssets()->create($validated);

        return new MovementAssetResource($movementAsset);
    }
}
