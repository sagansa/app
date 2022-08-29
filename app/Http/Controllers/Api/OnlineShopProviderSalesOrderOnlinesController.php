<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\OnlineShopProvider;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderOnlineResource;
use App\Http\Resources\SalesOrderOnlineCollection;

class OnlineShopProviderSalesOrderOnlinesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OnlineShopProvider $onlineShopProvider
     * @return \Illuminate\Http\Response
     */
    public function index(
        Request $request,
        OnlineShopProvider $onlineShopProvider
    ) {
        $this->authorize('view', $onlineShopProvider);

        $search = $request->get('search', '');

        $salesOrderOnlines = $onlineShopProvider
            ->salesOrderOnlines()
            ->search($search)
            ->latest()
            ->paginate();

        return new SalesOrderOnlineCollection($salesOrderOnlines);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OnlineShopProvider $onlineShopProvider
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        OnlineShopProvider $onlineShopProvider
    ) {
        $this->authorize('create', SalesOrderOnline::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'store_id' => ['required', 'exists:stores,id'],
            'delivery_service_id' => [
                'required',
                'exists:delivery_services,id',
            ],
            'customer_id' => ['nullable', 'exists:customers,id'],
            'delivery_address_id' => [
                'nullable',
                'exists:delivery_addresses,id',
            ],
            'receipt_no' => ['nullable', 'max:255', 'string'],
            'date' => ['required', 'date'],
            'status' => ['required', 'in:1,2,3,4'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
            'notes' => ['nullable', 'max:255', 'string'],
            'image_sent' => ['image', 'nullable'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        if ($request->hasFile('image_sent')) {
            $validated['image_sent'] = $request
                ->file('image_sent')
                ->store('public');
        }

        $salesOrderOnline = $onlineShopProvider
            ->salesOrderOnlines()
            ->create($validated);

        return new SalesOrderOnlineResource($salesOrderOnline);
    }
}
