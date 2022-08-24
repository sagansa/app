<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Store;
use App\Models\UserCashless;
use Illuminate\Http\Request;
use App\Models\StoreCashless;
use App\Models\CashlessProvider;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserCashlessStoreRequest;
use App\Http\Requests\UserCashlessUpdateRequest;

class UserCashlessController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', UserCashless::class);

        $search = $request->get('search', '');

        $userCashlesses = UserCashless::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.user_cashlesses.index',
            compact('userCashlesses', 'search')
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
            'app.user_cashlesses.create',
            compact('cashlessProviders', 'stores', 'storeCashlesses')
        );
    }

    /**
     * @param \App\Http\Requests\UserCashlessStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCashlessStoreRequest $request)
    {
        $this->authorize('create', UserCashless::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $userCashless = UserCashless::create($validated);

        return redirect()
            ->route('user-cashlesses.edit', $userCashless)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UserCashless $userCashless
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, UserCashless $userCashless)
    {
        $this->authorize('view', $userCashless);

        return view('app.user_cashlesses.show', compact('userCashless'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UserCashless $userCashless
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, UserCashless $userCashless)
    {
        $this->authorize('update', $userCashless);

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
            'app.user_cashlesses.edit',
            compact(
                'userCashless',
                'cashlessProviders',
                'stores',
                'storeCashlesses'
            )
        );
    }

    /**
     * @param \App\Http\Requests\UserCashlessUpdateRequest $request
     * @param \App\Models\UserCashless $userCashless
     * @return \Illuminate\Http\Response
     */
    public function update(
        UserCashlessUpdateRequest $request,
        UserCashless $userCashless
    ) {
        $this->authorize('update', $userCashless);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $userCashless->update($validated);

        return redirect()
            ->route('user-cashlesses.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UserCashless $userCashless
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, UserCashless $userCashless)
    {
        $this->authorize('delete', $userCashless);

        $userCashless->delete();

        return redirect()
            ->route('user-cashlesses.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
