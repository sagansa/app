<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Store;
use App\Models\ShiftStore;
use App\Models\ClosingStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ClosingStoreStoreRequest;
use App\Http\Requests\ClosingStoreUpdateRequest;

class ClosingStoreController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ClosingStore::class);

        $search = $request->get('search', '');

        $closingStores = ClosingStore::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if(Auth::user()->hasRole('supervisor')) {
            $closingStores = ClosingStore::search($search)
                ->where('approved_by_id', '=', Auth::user()->id)
                ->orWhere('approved_by_id', '=', NULL)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } elseif (Auth::user()->hasRole('super-admin|manager')) {
            $closingStores = ClosingStore::search($search)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } else if (Auth::user()->hasRole('staff')) {
            $closingStores = ClosingStore::search($search)
                ->where('created_by_id', '=', Auth::user()->id)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        return view(
            'app.closing_stores.index',
            compact('closingStores', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $stores = Store::orderBy('nickname', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('nickname', 'id');
        $shiftStores = ShiftStore::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.closing_stores.create',
            compact('stores', 'shiftStores', 'users', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\ClosingStoreStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClosingStoreStoreRequest $request)
    {
        $this->authorize('create', ClosingStore::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $closingStore = ClosingStore::create($validated);


        return redirect()
            ->route('closing-stores.show', $closingStore)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ClosingStore $closingStore)
    {
        $this->authorize('view', $closingStore);

        return view('app.closing_stores.show', compact('closingStore'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ClosingStore $closingStore)
    {
        $this->authorize('update', $closingStore);

        $stores = Store::orderBy('nickname', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('nickname', 'id');
        $shiftStores = ShiftStore::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');


        return view(
            'app.closing_stores.edit',
            compact(
                'closingStore',
                'stores',
                'shiftStores',
                'users',
                'users',
                'users'
            )
        );
    }

    /**
     * @param \App\Http\Requests\ClosingStoreUpdateRequest $request
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function update(
        ClosingStoreUpdateRequest $request,
        ClosingStore $closingStore
    ) {
        $this->authorize('update', $closingStore);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $closingStore->update($validated);

        return redirect()
            ->route('closing-stores.show', $closingStore)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingStore $closingStore
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ClosingStore $closingStore)
    {
        $this->authorize('delete', $closingStore);

        $closingStore->delete();

        return redirect()
            ->route('closing-stores.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
