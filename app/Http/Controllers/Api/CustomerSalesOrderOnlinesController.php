<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderOnlineResource;
use App\Http\Resources\SalesOrderOnlineCollection;

class CustomerSalesOrderOnlinesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Customer $customer)
    {
        $this->authorize('view', $customer);

        $search = $request->get('search', '');

        $salesOrderOnlines = $customer
            ->salesOrderOnlines()
            ->search($search)
            ->latest()
            ->paginate();

        return new SalesOrderOnlineCollection($salesOrderOnlines);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Customer $customer)
    {
        $this->authorize('create', SalesOrderOnline::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image', 'max:1024'],
            'store_id' => ['required', 'exists:stores,id'],
            'online_shop_provider_id' => [
                'required',
                'exists:online_shop_providers,id',
            ],
            'delivery_service_id' => [
                'required',
                'exists:delivery_services,id',
            ],
            'receipt_no' => ['nullable', 'max:255', 'string'],
            'date' => ['required', 'date'],
            'status' => ['required', 'max:255'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $salesOrderOnline = $customer->salesOrderOnlines()->create($validated);

        return new SalesOrderOnlineResource($salesOrderOnline);
    }
}