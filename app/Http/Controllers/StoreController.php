<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\StoreUpdateRequest;

class StoreController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Store::class);

        $search = $request->get('search', '');

        $stores = Store::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.stores.index', compact('stores', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.stores.create');
    }

    /**
     * @param \App\Http\Requests\StoreStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStoreRequest $request)
    {
        $this->authorize('create', Store::class);

        $validated = $request->validated();

        $validated['user_id'] = auth()->user()->id;

        $store = Store::create($validated);

        return redirect()
            ->route('stores.edit', $store)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Store $store)
    {
        $this->authorize('view', $store);

        return view('app.stores.show', compact('store'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Store $store)
    {
        $this->authorize('update', $store);

        return view('app.stores.edit', compact('store'));
    }

    /**
     * @param \App\Http\Requests\StoreUpdateRequest $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateRequest $request, Store $store)
    {
        $this->authorize('update', $store);

        $validated = $request->validated();

        $store->update($validated);

        return redirect()
            ->route('stores.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Store $store)
    {
        $this->authorize('delete', $store);

        $store->delete();

        return redirect()
            ->route('stores.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
