<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use App\Models\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductionStoreRequest;
use App\Http\Requests\ProductionUpdateRequest;

class ProductionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Production::class);

        $search = $request->get('search', '');

        // $productions = Production::search($search)
        //     ->latest()
        //     ->paginate(10)
        //     ->withQueryString();

        if(Auth::user()->hasRole('supervisor')) {
            $productions = Production::search($search)
                ->where('approved_by_id', '=', Auth::user()->id)
                ->orWhere('approved_by_id', '=', NULL)
                ->orderBy('date', 'desc')
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } elseif (Auth::user()->hasRole('super-admin|manager')) {
            $productions = Production::search($search)
                ->orderBy('date', 'desc')
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } else if (Auth::user()->hasRole('staff')) {
            $productions = Production::search($search)
                ->where('created_by_id', '=', Auth::user()->id)
                ->orderBy('date', 'desc')
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        return view('app.productions.index', compact('productions', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $stores = Store::orderBy('name', 'asc')
            ->whereIn('status', ['3', '5', '6', '7'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.productions.create',
            compact('stores', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\ProductionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductionStoreRequest $request)
    {
        $this->authorize('create', Production::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $production = Production::create($validated);

        return redirect()
            ->route('productions.edit', $production)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Production $production)
    {
        $this->authorize('view', $production);

        return view('app.productions.show', compact('production'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Production $production)
    {
        $this->authorize('update', $production);

        $stores = Store::orderBy('name', 'asc')
            ->whereIn('status', ['3', '5', '6', '7'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.productions.edit',
            compact('production', 'stores', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\ProductionUpdateRequest $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function update(
        ProductionUpdateRequest $request,
        Production $production
    ) {
        $this->authorize('update', $production);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $production->update($validated);

        return redirect()
            ->route('productions.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Production $production
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Production $production)
    {
        $this->authorize('delete', $production);

        $production->delete();

        return redirect()
            ->route('productions.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function check(Request $request)
    {
        $this->authorize('view-any', Production::class);

        return view('app.productions.check');
    }
}
