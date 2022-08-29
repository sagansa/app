<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderOnlineResource;
use App\Http\Resources\SalesOrderOnlineCollection;

class StoreSalesOrderOnlinesController extends Controller
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

        $salesOrderOnlines = $store
            ->salesOrderOnlines()
            ->search($search)
            ->latest()
            ->paginate();

        return new SalesOrderOnlineCollection($salesOrderOnlines);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', SalesOrderOnline::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'online_shop_provider_id' => [
                'required',
                'exists:online_shop_providers,id',
            ],
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

        $salesOrderOnline = $store->salesOrderOnlines()->create($validated);

        return new SalesOrderOnlineResource($salesOrderOnline);
    }
}
