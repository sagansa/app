<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\TransferStock;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TransferStockStoreRequest;
use App\Http\Requests\TransferStockUpdateRequest;

class TransferStockController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', TransferStock::class);

        $search = $request->get('search', '');

        $transferStocks = TransferStock::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if(Auth::user()->hasRole('supervisor')) {
            $transferStocks = TransferStock::search($search)
                ->where('approved_by_id', '=', Auth::user()->id)
                ->orWhere('approved_by_id', '=', NULL)
                ->where('received_by_id', '=', Auth::user()->id)
                ->orWhere('sent_by_id', '=', Auth::user()->id)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } elseif (Auth::user()->hasRole('super-admin|manager')) {
            $transferStocks = TransferStock::search($search)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } else if (Auth::user()->hasRole('staff')) {
            $transferStocks = TransferStock::search($search)
                ->where('received_by_id', '=', Auth::user()->id)
                ->orWhere('sent_by_id', '=', Auth::user()->id)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        return view(
            'app.transfer_stocks.index',
            compact('transferStocks', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $stores = Store::orderBy('name', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('name', 'id');
        $users = User::whereHas('roles', function ($q) {
                $q->where('roles.name','=','staff')->orWhere('roles.name','=','supervisor');
            })->orderBy('name', 'asc')
            ->pluck('name', 'id');

        return view(
            'app.transfer_stocks.create',
            compact('stores', 'stores', 'users', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\TransferStockStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransferStockStoreRequest $request)
    {
        $this->authorize('create', TransferStock::class);

        $validated = $request->validated();

        // $validated['created_by_id'] = auth()->user()->id;
        // $validated['status'] = '1';

        $transferStock = TransferStock::create($validated);

        return redirect()
            ->route('transfer-stocks.edit', $transferStock)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferStock $transferStock
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, TransferStock $transferStock)
    {
        $this->authorize('view', $transferStock);

        return view('app.transfer_stocks.show', compact('transferStock'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferStock $transferStock
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, TransferStock $transferStock)
    {
        $this->authorize('update', $transferStock);

        $stores = Store::orderBy('name', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('name', 'id');
        $users = User::whereHas('roles', function ($q) {
                    $q->where('roles.name','=','staff')->orWhere('roles.name','=','supervisor');
                })
            ->orderBy('name', 'asc')
            ->pluck('name', 'id');

        return view(
            'app.transfer_stocks.edit',
            compact(
                'transferStock',
                'stores',
                'stores',
                'users',
                'users',
                'users'
            )
        );
    }

    /**
     * @param \App\Http\Requests\TransferStockUpdateRequest $request
     * @param \App\Models\TransferStock $transferStock
     * @return \Illuminate\Http\Response
     */
    public function update(
        TransferStockUpdateRequest $request,
        TransferStock $transferStock
    ) {
        $this->authorize('update', $transferStock);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $transferStock->update($validated);

        return redirect()
            ->route('transfer-stocks.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferStock $transferStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, TransferStock $transferStock)
    {
        $this->authorize('delete', $transferStock);

        $transferStock->delete();

        return redirect()
            ->route('transfer-stocks.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
