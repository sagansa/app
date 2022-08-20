<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use App\Models\OnlineShopProvider;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OnlineShopProviderStoreRequest;
use App\Http\Requests\OnlineShopProviderUpdateRequest;

class OnlineShopProviderController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', OnlineShopProvider::class);

        $search = $request->get('search', '');

        $onlineShopProviders = OnlineShopProvider::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.online_shop_providers.index',
            compact('onlineShopProviders', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.online_shop_providers.create');
    }

    /**
     * @param \App\Http\Requests\OnlineShopProviderStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OnlineShopProviderStoreRequest $request)
    {
        $this->authorize('create', OnlineShopProvider::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $onlineShopProvider = OnlineShopProvider::create($validated);

        return redirect()
            ->route('online-shop-providers.edit', $onlineShopProvider)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OnlineShopProvider $onlineShopProvider
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        OnlineShopProvider $onlineShopProvider
    ) {
        $this->authorize('view', $onlineShopProvider);

        return view(
            'app.online_shop_providers.show',
            compact('onlineShopProvider')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OnlineShopProvider $onlineShopProvider
     * @return \Illuminate\Http\Response
     */
    public function edit(
        Request $request,
        OnlineShopProvider $onlineShopProvider
    ) {
        $this->authorize('update', $onlineShopProvider);

        return view(
            'app.online_shop_providers.edit',
            compact('onlineShopProvider')
        );
    }

    /**
     * @param \App\Http\Requests\OnlineShopProviderUpdateRequest $request
     * @param \App\Models\OnlineShopProvider $onlineShopProvider
     * @return \Illuminate\Http\Response
     */
    public function update(
        OnlineShopProviderUpdateRequest $request,
        OnlineShopProvider $onlineShopProvider
    ) {
        $this->authorize('update', $onlineShopProvider);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $onlineShopProvider->update($validated);

        return redirect()
            ->route('online-shop-providers.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OnlineShopProvider $onlineShopProvider
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        OnlineShopProvider $onlineShopProvider
    ) {
        $this->authorize('delete', $onlineShopProvider);

        $onlineShopProvider->delete();

        return redirect()
            ->route('online-shop-providers.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
