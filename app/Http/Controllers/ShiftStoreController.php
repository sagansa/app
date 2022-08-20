<?php

namespace App\Http\Controllers;

use Image;
use App\Models\ShiftStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ShiftStoreStoreRequest;
use App\Http\Requests\ShiftStoreUpdateRequest;

class ShiftStoreController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ShiftStore::class);

        $search = $request->get('search', '');

        $shiftStores = ShiftStore::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.shift_stores.index', compact('shiftStores', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.shift_stores.create');
    }

    /**
     * @param \App\Http\Requests\ShiftStoreStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShiftStoreStoreRequest $request)
    {
        $this->authorize('create', ShiftStore::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $shiftStore = ShiftStore::create($validated);

        return redirect()
            ->route('shift-stores.edit', $shiftStore)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ShiftStore $shiftStore
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ShiftStore $shiftStore)
    {
        $this->authorize('view', $shiftStore);

        return view('app.shift_stores.show', compact('shiftStore'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ShiftStore $shiftStore
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ShiftStore $shiftStore)
    {
        $this->authorize('update', $shiftStore);

        return view('app.shift_stores.edit', compact('shiftStore'));
    }

    /**
     * @param \App\Http\Requests\ShiftStoreUpdateRequest $request
     * @param \App\Models\ShiftStore $shiftStore
     * @return \Illuminate\Http\Response
     */
    public function update(
        ShiftStoreUpdateRequest $request,
        ShiftStore $shiftStore
    ) {
        $this->authorize('update', $shiftStore);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $shiftStore->update($validated);

        return redirect()
            ->route('shift-stores.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ShiftStore $shiftStore
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ShiftStore $shiftStore)
    {
        $this->authorize('delete', $shiftStore);

        $shiftStore->delete();

        return redirect()
            ->route('shift-stores.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
