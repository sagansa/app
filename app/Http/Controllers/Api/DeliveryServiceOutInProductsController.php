<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\DeliveryService;
use App\Http\Controllers\Controller;
use App\Http\Resources\OutInProductResource;
use App\Http\Resources\OutInProductCollection;

class DeliveryServiceOutInProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DeliveryService $deliveryService
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DeliveryService $deliveryService)
    {
        $this->authorize('view', $deliveryService);

        $search = $request->get('search', '');

        $outInProducts = $deliveryService
            ->outInProducts()
            ->search($search)
            ->latest()
            ->paginate();

        return new OutInProductCollection($outInProducts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DeliveryService $deliveryService
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DeliveryService $deliveryService)
    {
        $this->authorize('create', OutInProduct::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:1024'],
            'stock_card_id' => ['required', 'exists:stock_cards,id'],
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

        $outInProduct = $deliveryService->outInProducts()->create($validated);

        return new OutInProductResource($outInProduct);
    }
}
