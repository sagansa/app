<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use App\Models\CashlessProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\ParentAccountCashless;
use App\Http\Requests\ParentAccountCashlessStoreRequest;
use App\Http\Requests\ParentAccountCashlessUpdateRequest;

class ParentAccountCashlessController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ParentAccountCashless::class);

        $search = $request->get('search', '');

        $parentAccountCashlesses = ParentAccountCashless::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.parent_account_cashlesses.index',
            compact('parentAccountCashlesses', 'search')
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

        return view(
            'app.parent_account_cashlesses.create',
            compact('cashlessProviders')
        );
    }

    /**
     * @param \App\Http\Requests\ParentAccountCashlessStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParentAccountCashlessStoreRequest $request)
    {
        $this->authorize('create', ParentAccountCashless::class);

        $validated = $request->validated();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $parentAccountCashless = ParentAccountCashless::create($validated);

        return redirect()
            ->route('parent-account-cashlesses.edit', $parentAccountCashless)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ParentAccountCashless $parentAccountCashless
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        ParentAccountCashless $parentAccountCashless
    ) {
        $this->authorize('view', $parentAccountCashless);

        return view(
            'app.parent_account_cashlesses.show',
            compact('parentAccountCashless')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ParentAccountCashless $parentAccountCashless
     * @return \Illuminate\Http\Response
     */
    public function edit(
        Request $request,
        ParentAccountCashless $parentAccountCashless
    ) {
        $this->authorize('update', $parentAccountCashless);

        $cashlessProviders = CashlessProvider::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.parent_account_cashlesses.edit',
            compact('parentAccountCashless', 'cashlessProviders')
        );
    }

    /**
     * @param \App\Http\Requests\ParentAccountCashlessUpdateRequest $request
     * @param \App\Models\ParentAccountCashless $parentAccountCashless
     * @return \Illuminate\Http\Response
     */
    public function update(
        ParentAccountCashlessUpdateRequest $request,
        ParentAccountCashless $parentAccountCashless
    ) {
        $this->authorize('update', $parentAccountCashless);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        if (
            auth()
                ->user()
                ->hasRole('staff') &&
            $validated['status'] == '3'
        ) {
            $validated['status'] = '4';
        }

        $parentAccountCashless->update($validated);

        return redirect()
            ->route('parent-account-cashlesses.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ParentAccountCashless $parentAccountCashless
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        ParentAccountCashless $parentAccountCashless
    ) {
        $this->authorize('delete', $parentAccountCashless);

        $parentAccountCashless->delete();

        return redirect()
            ->route('parent-account-cashlesses.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
