<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\RestaurantCategory;
use Illuminate\Support\Facades\Auth;
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
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.restaurant_categories.index',
            compact('restaurantCategories', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.restaurant_categories.create');
    }

    /**
     * @param \App\Http\Requests\RestaurantCategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RestaurantCategoryStoreRequest $request)
    {
        $this->authorize('create', RestaurantCategory::class);

        $validated = $request->validated();

        $validated['user_id'] = auth()->user()->id;

        $restaurantCategory = RestaurantCategory::create($validated);

        return redirect()
            ->route('restaurant-categories.edit', $restaurantCategory)
            ->withSuccess(__('crud.common.created'));
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

        return view(
            'app.restaurant_categories.show',
            compact('restaurantCategory')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RestaurantCategory $restaurantCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(
        Request $request,
        RestaurantCategory $restaurantCategory
    ) {
        $this->authorize('update', $restaurantCategory);

        return view(
            'app.restaurant_categories.edit',
            compact('restaurantCategory')
        );
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

        return redirect()
            ->route('restaurant-categories.index')
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('restaurant-categories.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
