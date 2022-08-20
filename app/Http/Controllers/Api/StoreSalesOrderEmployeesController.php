<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderEmployeeResource;
use App\Http\Resources\SalesOrderEmployeeCollection;

class StoreSalesOrderEmployeesController extends Controller
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

        $salesOrderEmployees = $store
            ->salesOrderEmployees()
            ->search($search)
            ->latest()
            ->paginate();

        return new SalesOrderEmployeeCollection($salesOrderEmployees);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', SalesOrderEmployee::class);

        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'delivery_address_id' => [
                'required',
                'exists:delivery_addresses,id',
            ],
            'date' => ['required', 'date'],
            'total' => ['required', 'max:255'],
            'image' => ['nullable', 'image', 'max:1024'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
            'status' => ['required', 'max:255'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $salesOrderEmployee = $store->salesOrderEmployees()->create($validated);

        return new SalesOrderEmployeeResource($salesOrderEmployee);
    }
}
