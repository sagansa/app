<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Bank;
use App\Models\Regency;
use App\Models\Village;
use App\Models\Supplier;
use App\Models\Province;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SupplierStoreRequest;
use App\Http\Requests\SupplierUpdateRequest;

class SupplierController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Supplier::class);

        $search = $request->get('search', '');

        $suppliers = Supplier::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.suppliers.index', compact('suppliers', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $provinces = Province::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $regencies = Regency::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $villages = Village::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $districts = District::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $banks = Bank::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.suppliers.create',
            compact('provinces', 'regencies', 'villages', 'districts', 'banks')
        );
    }

    /**
     * @param \App\Http\Requests\SupplierStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierStoreRequest $request)
    {
        $this->authorize('create', Supplier::class);

        $validated = $request->validated();

        $validated['user_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $supplier = Supplier::create($validated);

        return redirect()
            ->route('suppliers.edit', $supplier)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Supplier $supplier)
    {
        $this->authorize('view', $supplier);

        return view('app.suppliers.show', compact('supplier'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Supplier $supplier)
    {
        $this->authorize('update', $supplier);

        $provinces = Province::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $regencies = Regency::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $villages = Village::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $districts = District::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $banks = Bank::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.suppliers.edit',
            compact(
                'supplier',
                'provinces',
                'regencies',
                'villages',
                'districts',
                'banks'
            )
        );
    }

    /**
     * @param \App\Http\Requests\SupplierUpdateRequest $request
     * @param \App\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierUpdateRequest $request, Supplier $supplier)
    {
        $this->authorize('update', $supplier);

        $validated = $request->validated();

        $supplier->update($validated);

        return redirect()
            ->route('suppliers.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Supplier $supplier)
    {
        $this->authorize('delete', $supplier);

        $supplier->delete();

        return redirect()
            ->route('suppliers.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function fetchRegencies($province_id = null) {
        $regencies = Regency::where('province_id', $province_id)->pluck('name', 'id');

        return response()->json([
            'regencies' => $regencies
        ]);
    }

    public function fetchVillages($regency_id = null) {
        $villages = Village::where('regency_id', $regency_id)->pluck('name', 'id');

        return response()->json([
            'villages' => $villages
        ]);
    }

    public function fetchDistricts($village_id = null) {
        $districts = District::where('village_id', $village_id)->pluck('name', 'id');

        return response()->json([
            'districts' => $districts
        ]);
    }
}
