<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RestaurantCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestaurantCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the restaurantCategory can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list restaurantcategories');
    }

    /**
     * Determine whether the restaurantCategory can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RestaurantCategory  $model
     * @return mixed
     */
    public function view(User $user, RestaurantCategory $model)
    {
        return $user->hasPermissionTo('view restaurantcategories');
    }

    /**
     * Determine whether the restaurantCategory can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create restaurantcategories');
    }

    /**
     * Determine whether the restaurantCategory can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RestaurantCategory  $model
     * @return mixed
     */
    public function update(User $user, RestaurantCategory $model)
    {
        return $user->hasPermissionTo('update restaurantcategories');
    }

    /**
     * Determine whether the restaurantCategory can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RestaurantCategory  $model
     * @return mixed
     */
    public function delete(User $user, RestaurantCategory $model)
    {
        return $user->hasPermissionTo('delete restaurantcategories');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RestaurantCategory  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete restaurantcategories');
    }

    /**
     * Determine whether the restaurantCategory can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RestaurantCategory  $model
     * @return mixed
     */
    public function restore(User $user, RestaurantCategory $model)
    {
        return false;
    }

    /**
     * Determine whether the restaurantCategory can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RestaurantCategory  $model
     * @return mixed
     */
    public function forceDelete(User $user, RestaurantCategory $model)
    {
        return false;
    }
}
