<?php

namespace App\Http\Controllers\Api;

use App\Models\StockCard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OutInProductResource;
use App\Http\Resources\OutInProductCollection;

class StockCardOutInProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StockCard $stockCard
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, StockCard $stockCard)
    {
        $this->authorize('view', $stockCard);

        $search = $request->get('search', '');

        $outInProducts = $stockCard
            ->outInProducts()
            ->search($search)
            ->latest()
            ->paginate();

        return new OutInProductCollection($outInProducts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StockCard $stockCard
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, StockCard $stockCard)
    {
        $this->authorize('create', OutInProduct::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:1024'],
            'out_in' => ['required', 'max:255'],
            're' => ['nullable', 'max:50', 'string'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $outInProduct = $stockCard->outInProducts()->create($validated);

        return new OutInProductResource($outInProduct);
    }
}
