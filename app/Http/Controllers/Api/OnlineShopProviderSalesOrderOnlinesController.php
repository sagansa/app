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
            'image' => ['nullable', 'image', 'max:1024'],
            'store_id' => ['required', 'exists:stores,id'],
            'customer_id' => ['nullable', 'exists:customers,id'],
            'receipt_no' => ['nullable', 'max:255', 'string'],
            'date' => ['required', 'date'],
            'total' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'max:255'],
            'status' => ['required', 'max:255'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'notes' => ['required', 'max:255', 'string'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $salesOrderOnline = $onlineShopProvider
            ->salesOrderOnlines()
            ->create($validated);

        return new SalesOrderOnlineResource($salesOrderOnline);
    }
}
