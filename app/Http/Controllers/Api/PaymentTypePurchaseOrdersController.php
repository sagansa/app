<?php

namespace App\Http\Controllers\Api;

use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseOrderResource;
use App\Http\Resources\PurchaseOrderCollection;

class PaymentTypePurchaseOrdersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentType $paymentType
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PaymentType $paymentType)
    {
        $this->authorize('view', $paymentType);

        $search = $request->get('search', '');

        $purchaseOrders = $paymentType
            ->purchaseOrders()
            ->search($search)
            ->latest()
            ->paginate();

        return new PurchaseOrderCollection($purchaseOrders);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentType $paymentType
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, PaymentType $paymentType)
    {
        $this->authorize('create', PurchaseOrder::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'store_id' => ['required', 'exists:stores,id'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
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

        $purchaseOrder = $paymentType->purchaseOrders()->create($validated);

        return new PurchaseOrderResource($purchaseOrder);
    }
}
