<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MovementAssetResource;
use App\Http\Resources\MovementAssetCollection;

class UserMovementAssetsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $movementAssets = $user
            ->movementAssets()
            ->search($search)
            ->latest()
            ->paginate();

        return new MovementAssetCollection($movementAssets);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
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

        $movementAsset = $user->movementAssets()->create($validated);

        return new MovementAssetResource($movementAsset);
    }
}
