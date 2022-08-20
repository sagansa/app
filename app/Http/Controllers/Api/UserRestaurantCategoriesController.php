<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RestaurantCategoryResource;
use App\Http\Resources\RestaurantCategoryCollection;

class UserRestaurantCategoriesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $restaurantCategories = $user
            ->restaurantCategories()
            ->search($search)
            ->latest()
            ->paginate();

        return new RestaurantCategoryCollection($restaurantCategories);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', RestaurantCategory::class);

        $validated = $request->validate([
            'name' => ['required', 'max:50', 'string'],
        ]);

        $restaurantCategory = $user->restaurantCategories()->create($validated);

        return new RestaurantCategoryResource($restaurantCategory);
    }
}
