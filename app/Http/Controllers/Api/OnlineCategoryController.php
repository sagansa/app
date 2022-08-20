<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\OnlineCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\OnlineCategoryResource;
use App\Http\Resources\OnlineCategoryCollection;
use App\Http\Requests\OnlineCategoryStoreRequest;
use App\Http\Requests\OnlineCategoryUpdateRequest;

class OnlineCategoryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', OnlineCategory::class);

        $search = $request->get('search', '');

        $onlineCategories = OnlineCategory::search($search)
            ->latest()
            ->paginate();

        return new OnlineCategoryCollection($onlineCategories);
    }

    /**
     * @param \App\Http\Requests\OnlineCategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OnlineCategoryStoreRequest $request)
    {
        $this->authorize('create', OnlineCategory::class);

        $validated = $request->validated();

        $onlineCategory = OnlineCategory::create($validated);

        return new OnlineCategoryResource($onlineCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OnlineCategory $onlineCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, OnlineCategory $onlineCategory)
    {
        $this->authorize('view', $onlineCategory);

        return new OnlineCategoryResource($onlineCategory);
    }

    /**
     * @param \App\Http\Requests\OnlineCategoryUpdateRequest $request
     * @param \App\Models\OnlineCategory $onlineCategory
     * @return \Illuminate\Http\Response
     */
    public function update(
        OnlineCategoryUpdateRequest $request,
        OnlineCategory $onlineCategory
    ) {
        $this->authorize('update', $onlineCategory);

        $validated = $request->validated();

        $onlineCategory->update($validated);

        return new OnlineCategoryResource($onlineCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OnlineCategory $onlineCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, OnlineCategory $onlineCategory)
    {
        $this->authorize('delete', $onlineCategory);

        $onlineCategory->delete();

        return response()->noContent();
    }
}
