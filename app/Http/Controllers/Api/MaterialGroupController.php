<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\MaterialGroup;
use App\Http\Controllers\Controller;
use App\Http\Resources\MaterialGroupResource;
use App\Http\Resources\MaterialGroupCollection;
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
            ->paginate();

        return new MaterialGroupCollection($materialGroups);
    }

    /**
     * @param \App\Http\Requests\MaterialGroupStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MaterialGroupStoreRequest $request)
    {
        $this->authorize('create', MaterialGroup::class);

        $validated = $request->validated();

        $materialGroup = MaterialGroup::create($validated);

        return new MaterialGroupResource($materialGroup);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\MaterialGroup $materialGroup
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MaterialGroup $materialGroup)
    {
        $this->authorize('view', $materialGroup);

        return new MaterialGroupResource($materialGroup);
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

        return new MaterialGroupResource($materialGroup);
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

        return response()->noContent();
    }
}
