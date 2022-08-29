<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OutInProductResource;
use App\Http\Resources\OutInProductCollection;

class UserOutInProductsController extends Controller
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

        $outInProducts = $user
            ->outInProductsApproved()
            ->search($search)
            ->latest()
            ->paginate();

        return new OutInProductCollection($outInProducts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', OutInProduct::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:1024'],
            'stock_card_id' => ['required', 'exists:stock_cards,id'],
            'out_in' => ['required', 'max:255'],
            're' => ['nullable', 'max:50', 'string'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $outInProduct = $user->outInProductsApproved()->create($validated);

        return new OutInProductResource($outInProduct);
    }
}
