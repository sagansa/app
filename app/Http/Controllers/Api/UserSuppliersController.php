<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierResource;
use App\Http\Resources\SupplierCollection;

class UserSuppliersController extends Controller
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

        $suppliers = $user
            ->suppliers()
            ->search($search)
            ->latest()
            ->paginate();

        return new SupplierCollection($suppliers);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Supplier::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'no_telp' => ['nullable', 'max:255', 'string'],
            'address' => ['nullable', 'max:255', 'string'],
            'province_id' => ['nullable', 'exists:provinces,id'],
            'regency_id' => ['nullable', 'exists:regencies,id'],
            'village_id' => ['nullable', 'exists:villages,id'],
            'district_id' => ['nullable', 'exists:districts,id'],
            'codepos' => ['nullable', 'numeric'],
            'bank_id' => ['nullable', 'exists:banks,id'],
            'bank_account_name' => ['nullable', 'max:255', 'string'],
            'bank_account_no' => ['nullable', 'max:255', 'string'],
            'status' => ['required', 'max:255'],
        ]);

        $supplier = $user->suppliers()->create($validated);

        return new SupplierResource($supplier);
    }
}
