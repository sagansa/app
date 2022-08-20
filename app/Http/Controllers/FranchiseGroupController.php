<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\FranchiseGroup;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FranchiseGroupStoreRequest;
use App\Http\Requests\FranchiseGroupUpdateRequest;

class FranchiseGroupController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', FranchiseGroup::class);

        $search = $request->get('search', '');

        $franchiseGroups = FranchiseGroup::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.franchise_groups.index',
            compact('franchiseGroups', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view('app.franchise_groups.create', compact('users'));
    }

    /**
     * @param \App\Http\Requests\FranchiseGroupStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FranchiseGroupStoreRequest $request)
    {
        $this->authorize('create', FranchiseGroup::class);

        $validated = $request->validated();

        $validated['user_id'] = auth()->user()->id;

        $franchiseGroup = FranchiseGroup::create($validated);

        return redirect()
            ->route('franchise-groups.edit', $franchiseGroup)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FranchiseGroup $franchiseGroup
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FranchiseGroup $franchiseGroup)
    {
        $this->authorize('view', $franchiseGroup);

        return view('app.franchise_groups.show', compact('franchiseGroup'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FranchiseGroup $franchiseGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, FranchiseGroup $franchiseGroup)
    {
        $this->authorize('update', $franchiseGroup);

        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.franchise_groups.edit',
            compact('franchiseGroup', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\FranchiseGroupUpdateRequest $request
     * @param \App\Models\FranchiseGroup $franchiseGroup
     * @return \Illuminate\Http\Response
     */
    public function update(
        FranchiseGroupUpdateRequest $request,
        FranchiseGroup $franchiseGroup
    ) {
        $this->authorize('update', $franchiseGroup);

        $validated = $request->validated();

        $franchiseGroup->update($validated);

        return redirect()
            ->route('franchise-groups.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FranchiseGroup $franchiseGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, FranchiseGroup $franchiseGroup)
    {
        $this->authorize('delete', $franchiseGroup);

        $franchiseGroup->delete();

        return redirect()
            ->route('franchise-groups.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
