<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UnitStoreRequest;
use App\Http\Requests\UnitUpdateRequest;

class UnitController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Unit::class);

        $search = $request->get('search', '');

        $units = Unit::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.units.index', compact('units', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.units.create');
    }

    /**
     * @param \App\Http\Requests\UnitStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitStoreRequest $request)
    {
        $this->authorize('create', Unit::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $unit = Unit::create($validated);

        return redirect()
            ->route('units.edit', $unit)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Unit $unit)
    {
        $this->authorize('view', $unit);

        return view('app.units.show', compact('unit'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Unit $unit)
    {
        $this->authorize('update', $unit);

        return view('app.units.edit', compact('unit'));
    }

    /**
     * @param \App\Http\Requests\UnitUpdateRequest $request
     * @param \App\Models\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function update(UnitUpdateRequest $request, Unit $unit)
    {
        $this->authorize('update', $unit);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $unit->update($validated);

        return redirect()
            ->route('units.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Unit $unit)
    {
        $this->authorize('delete', $unit);

        $unit->delete();

        return redirect()
            ->route('units.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
