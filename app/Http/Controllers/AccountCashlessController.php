<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\StoreCashless;
use App\Models\AccountCashless;
use App\Models\CashlessProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AccountCashlessStoreRequest;
use App\Http\Requests\AccountCashlessUpdateRequest;

class AccountCashlessController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', AccountCashless::class);

        $search = $request->get('search', '');

        $accountCashlesses = AccountCashless::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.account_cashlesses.index',
            compact('accountCashlesses', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $cashlessProviders = CashlessProvider::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $stores = Store::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $storeCashlesses = StoreCashless::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.account_cashlesses.create',
            compact('cashlessProviders', 'stores', 'storeCashlesses')
        );
    }

    /**
     * @param \App\Http\Requests\AccountCashlessStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountCashlessStoreRequest $request)
    {
        $this->authorize('create', AccountCashless::class);

        $validated = $request->validated();

        $validated['status'] = '1';

        $accountCashless = AccountCashless::create($validated);

        return redirect()
            ->route('account-cashlesses.edit', $accountCashless)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AccountCashless $accountCashless
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, AccountCashless $accountCashless)
    {
        $this->authorize('view', $accountCashless);

        return view('app.account_cashlesses.show', compact('accountCashless'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AccountCashless $accountCashless
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, AccountCashless $accountCashless)
    {
        $this->authorize('update', $accountCashless);

        $cashlessProviders = CashlessProvider::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $stores = Store::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $storeCashlesses = StoreCashless::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.account_cashlesses.edit',
            compact(
                'accountCashless',
                'cashlessProviders',
                'stores',
                'storeCashlesses'
            )
        );
    }

    /**
     * @param \App\Http\Requests\AccountCashlessUpdateRequest $request
     * @param \App\Models\AccountCashless $accountCashless
     * @return \Illuminate\Http\Response
     */
    public function update(
        AccountCashlessUpdateRequest $request,
        AccountCashless $accountCashless
    ) {
        $this->authorize('update', $accountCashless);

        $validated = $request->validated();

        $accountCashless->update($validated);

        return redirect()
            ->route('account-cashlesses.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AccountCashless $accountCashless
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AccountCashless $accountCashless)
    {
        $this->authorize('delete', $accountCashless);

        $accountCashless->delete();

        return redirect()
            ->route('account-cashlesses.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
