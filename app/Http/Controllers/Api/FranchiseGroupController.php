<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\FranchiseGroup;
use App\Http\Controllers\Controller;
use App\Http\Resources\FranchiseGroupResource;
use App\Http\Resources\FranchiseGroupCollection;
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
            ->paginate();

        return new FranchiseGroupCollection($franchiseGroups);
    }

    /**
     * @param \App\Http\Requests\FranchiseGroupStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FranchiseGroupStoreRequest $request)
    {
        $this->authorize('create', FranchiseGroup::class);

        $validated = $request->validated();

        $franchiseGroup = FranchiseGroup::create($validated);

        return new FranchiseGroupResource($franchiseGroup);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FranchiseGroup $franchiseGroup
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, FranchiseGroup $franchiseGroup)
    {
        $this->authorize('view', $franchiseGroup);

        return new FranchiseGroupResource($franchiseGroup);
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

        return new FranchiseGroupResource($franchiseGroup);
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

        return response()->noContent();
    }
}
