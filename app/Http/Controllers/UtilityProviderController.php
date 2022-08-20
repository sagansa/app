<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use App\Models\UtilityProvider;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UtilityProviderStoreRequest;
use App\Http\Requests\UtilityProviderUpdateRequest;

class UtilityProviderController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', UtilityProvider::class);

        $search = $request->get('search', '');

        $utilityProviders = UtilityProvider::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.utility_providers.index',
            compact('utilityProviders', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.utility_providers.create');
    }

    /**
     * @param \App\Http\Requests\UtilityProviderStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UtilityProviderStoreRequest $request)
    {
        $this->authorize('create', UtilityProvider::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $utilityProvider = UtilityProvider::create($validated);

        return redirect()
            ->route('utility-providers.edit', $utilityProvider)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UtilityProvider $utilityProvider
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, UtilityProvider $utilityProvider)
    {
        $this->authorize('view', $utilityProvider);

        return view('app.utility_providers.show', compact('utilityProvider'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UtilityProvider $utilityProvider
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, UtilityProvider $utilityProvider)
    {
        $this->authorize('update', $utilityProvider);

        return view('app.utility_providers.edit', compact('utilityProvider'));
    }

    /**
     * @param \App\Http\Requests\UtilityProviderUpdateRequest $request
     * @param \App\Models\UtilityProvider $utilityProvider
     * @return \Illuminate\Http\Response
     */
    public function update(
        UtilityProviderUpdateRequest $request,
        UtilityProvider $utilityProvider
    ) {
        $this->authorize('update', $utilityProvider);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $utilityProvider->update($validated);

        return redirect()
            ->route('utility-providers.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UtilityProvider $utilityProvider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, UtilityProvider $utilityProvider)
    {
        $this->authorize('delete', $utilityProvider);

        $utilityProvider->delete();

        return redirect()
            ->route('utility-providers.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
