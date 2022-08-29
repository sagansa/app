<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryAddressResource;
use App\Http\Resources\DeliveryAddressCollection;

class CustomerDeliveryAddressesController extends Controller
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

        $deliveryAddresses = $customer
            ->deliveryAddresses()
            ->search($search)
            ->latest()
            ->paginate();

        return new DeliveryAddressCollection($deliveryAddresses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Customer $customer)
    {
        $this->authorize('create', DeliveryAddress::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'recipients_name' => ['required', 'max:255', 'string'],
            'recipients_telp_no' => ['required', 'max:255', 'string'],
            'address' => ['required', 'max:255', 'string'],
            'province_id' => ['nullable', 'exists:provinces,id'],
            'regency_id' => ['nullable', 'exists:regencies,id'],
            'district_id' => ['nullable', 'exists:districts,id'],
            'village_id' => ['nullable', 'exists:villages,id'],
            'codepos' => ['nullable', 'numeric'],
        ]);

        $deliveryAddress = $customer->deliveryAddresses()->create($validated);

        return new DeliveryAddressResource($deliveryAddress);
    }
}
