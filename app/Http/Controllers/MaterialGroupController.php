<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\MaterialGroup;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MaterialGroupStoreRequest;
use App\Http\Requests\MaterialGroupUpdateRequest;

class MaterialGroupController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', MaterialGroup::class);

        $search = $request->get('search', '');

        $materialGroups = MaterialGroup::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.material_groups.index',
            compact('materialGroups', 'search')
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

        return view('app.material_groups.create', compact('users'));
    }

    /**
     * @param \App\Http\Requests\MaterialGroupStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MaterialGroupStoreRequest $request)
    {
        $this->authorize('create', MaterialGroup::class);

        $validated = $request->validated();

        $validated['user_id'] = auth()->user()->id;

        $materialGroup = MaterialGroup::create($validated);

        return redirect()
            ->route('material-groups.edit', $materialGroup)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MaterialGroup $materialGroup
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MaterialGroup $materialGroup)
    {
        $this->authorize('view', $materialGroup);

        return view('app.material_groups.show', compact('materialGroup'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MaterialGroup $materialGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, MaterialGroup $materialGroup)
    {
        $this->authorize('update', $materialGroup);

        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.material_groups.edit',
            compact('materialGroup', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\MaterialGroupUpdateRequest $request
     * @param \App\Models\MaterialGroup $materialGroup
     * @return \Illuminate\Http\Response
     */
    public function update(
        MaterialGroupUpdateRequest $request,
        MaterialGroup $materialGroup
    ) {
        $this->authorize('update', $materialGroup);

        $validated = $request->validated();

        $materialGroup->update($validated);

        return redirect()
            ->route('material-groups.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MaterialGroup $materialGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, MaterialGroup $materialGroup)
    {
        $this->authorize('delete', $materialGroup);

        $materialGroup->delete();

        return redirect()
            ->route('material-groups.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
