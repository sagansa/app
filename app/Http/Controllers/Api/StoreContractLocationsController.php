<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContractLocationResource;
use App\Http\Resources\ContractLocationCollection;

class StoreContractLocationsController extends Controller
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

        $contractLocations = $store
            ->contractLocations()
            ->search($search)
            ->latest()
            ->paginate();

        return new ContractLocationCollection($contractLocations);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $store)
    {
        $this->authorize('create', ContractLocation::class);

        $validated = $request->validate([
            'file' => ['nullable', 'file'],
            'address' => ['required', 'max:255', 'string'],
            'province_id' => ['nullable', 'exists:provinces,id'],
            'regency_id' => ['nullable', 'exists:regencies,id'],
            'district_id' => ['nullable', 'exists:districts,id'],
            'village_id' => ['nullable', 'exists:villages,id'],
            'codepos' => ['nullable', 'numeric', 'min:0', 'digits:5'],
            'gps_location' => ['nullable', 'max:255', 'string'],
            'from_date' => ['required', 'date'],
            'until_date' => ['required', 'date'],
            'contact_person' => ['required', 'max:255', 'string'],
            'no_contact_person' => [
                'required',
                'numeric',
                'min:0',
                'digits_between:8,16',
            ],
            'nominal_contract_per_year' => ['required', 'numeric', 'min:0'],
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('public');
        }

        $contractLocation = $store->contractLocations()->create($validated);

        return new ContractLocationResource($contractLocation);
    }
}
