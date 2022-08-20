<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use App\Models\CashlessProvider;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CashlessProviderStoreRequest;
use App\Http\Requests\CashlessProviderUpdateRequest;

class CashlessProviderController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', CashlessProvider::class);

        $search = $request->get('search', '');

        $cashlessProviders = CashlessProvider::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.cashless_providers.index',
            compact('cashlessProviders', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.cashless_providers.create');
    }

    /**
     * @param \App\Http\Requests\CashlessProviderStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CashlessProviderStoreRequest $request)
    {
        $this->authorize('create', CashlessProvider::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $cashlessProvider = CashlessProvider::create($validated);

        return redirect()
            ->route('cashless-providers.edit', $cashlessProvider)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashlessProvider $cashlessProvider
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, CashlessProvider $cashlessProvider)
    {
        $this->authorize('view', $cashlessProvider);

        return view('app.cashless_providers.show', compact('cashlessProvider'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashlessProvider $cashlessProvider
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, CashlessProvider $cashlessProvider)
    {
        $this->authorize('update', $cashlessProvider);

        return view('app.cashless_providers.edit', compact('cashlessProvider'));
    }

    /**
     * @param \App\Http\Requests\CashlessProviderUpdateRequest $request
     * @param \App\Models\CashlessProvider $cashlessProvider
     * @return \Illuminate\Http\Response
     */
    public function update(
        CashlessProviderUpdateRequest $request,
        CashlessProvider $cashlessProvider
    ) {
        $this->authorize('update', $cashlessProvider);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $cashlessProvider->update($validated);

        return redirect()
            ->route('cashless-providers.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CashlessProvider $cashlessProvider
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        CashlessProvider $cashlessProvider
    ) {
        $this->authorize('delete', $cashlessProvider);

        $cashlessProvider->delete();

        return redirect()
            ->route('cashless-providers.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
