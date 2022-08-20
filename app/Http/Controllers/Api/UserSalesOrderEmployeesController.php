<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderEmployeeResource;
use App\Http\Resources\SalesOrderEmployeeCollection;

class UserSalesOrderEmployeesController extends Controller
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

        $salesOrderEmployees = $user
            ->salesOrderEmployeesApproved()
            ->search($search)
            ->latest()
            ->paginate();

        return new SalesOrderEmployeeCollection($salesOrderEmployees);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', SalesOrderEmployee::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
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
            'status' => ['required', 'max:255'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $salesOrderEmployee = $user
            ->salesOrderEmployeesApproved()
            ->create($validated);

        return new SalesOrderEmployeeResource($salesOrderEmployee);
    }
}
