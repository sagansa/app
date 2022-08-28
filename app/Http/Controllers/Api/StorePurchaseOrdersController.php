<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseOrderResource;
use App\Http\Resources\PurchaseOrderCollection;

class StorePurchaseOrdersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Store $store)
    {
        $this->authorize('view', $store);

        $search = $request->get('search', '');

        $purchaseOrders = $store
            ->purchaseOrders()
            ->search($search)
            ->latest()
            ->paginate();

        return new PurchaseOrderCollection($purchaseOrders);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', PurchaseOrder::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'date' => ['required', 'date'],
            'taxes' => ['required', 'numeric', 'min:0'],
            'discounts' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:255'],
            'payment_status' => ['required'],
            'order_status' => ['required'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $purchaseOrder = $store->purchaseOrders()->create($validated);

        return new PurchaseOrderResource($purchaseOrder);
    }
}
