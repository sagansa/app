<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\RestaurantCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\RestaurantCategoryResource;
use App\Http\Resources\RestaurantCategoryCollection;
use App\Http\Requests\RestaurantCategoryStoreRequest;
use App\Http\Requests\RestaurantCategoryUpdateRequest;

class RestaurantCategoryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', RestaurantCategory::class);

        $search = $request->get('search', '');

        $restaurantCategories = RestaurantCategory::search($search)
            ->latest()
            ->paginate();

        return new RestaurantCategoryCollection($restaurantCategories);
    }

    /**
     * @param \App\Http\Requests\RestaurantCategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RestaurantCategoryStoreRequest $request)
    {
        $this->authorize('create', RestaurantCategory::class);

        $validated = $request->validated();

        $restaurantCategory = RestaurantCategory::create($validated);

        return new RestaurantCategoryResource($restaurantCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RestaurantCategory $restaurantCategory
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        RestaurantCategory $restaurantCategory
    ) {
        $this->authorize('view', $restaurantCategory);

        return new RestaurantCategoryResource($restaurantCategory);
    }

    /**
     * @param \App\Http\Requests\RestaurantCategoryUpdateRequest $request
     * @param \App\Models\RestaurantCategory $restaurantCategory
     * @return \Illuminate\Http\Response
     */
    public function update(
        RestaurantCategoryUpdateRequest $request,
        RestaurantCategory $restaurantCategory
    ) {
        $this->authorize('update', $restaurantCategory);

        $validated = $request->validated();

        $restaurantCategory->update($validated);

        return new RestaurantCategoryResource($restaurantCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RestaurantCategory $restaurantCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        RestaurantCategory $restaurantCategory
    ) {
        $this->authorize('delete', $restaurantCategory);

        $restaurantCategory->delete();

        return response()->noContent();
    }
}
