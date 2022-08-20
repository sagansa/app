<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OnlineCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class OnlineCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the onlineCategory can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list onlinecategories');
    }

    /**
     * Determine whether the onlineCategory can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OnlineCategory  $model
     * @return mixed
     */
    public function view(User $user, OnlineCategory $model)
    {
        return $user->hasPermissionTo('view onlinecategories');
    }

    /**
     * Determine whether the onlineCategory can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create onlinecategories');
    }

    /**
     * Determine whether the onlineCategory can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OnlineCategory  $model
     * @return mixed
     */
    public function update(User $user, OnlineCategory $model)
    {
        return $user->hasPermissionTo('update onlinecategories');
    }

    /**
     * Determine whether the onlineCategory can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OnlineCategory  $model
     * @return mixed
     */
    public function delete(User $user, OnlineCategory $model)
    {
        return $user->hasPermissionTo('delete onlinecategories');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OnlineCategory  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete onlinecategories');
    }

    /**
     * Determine whether the onlineCategory can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OnlineCategory  $model
     * @return mixed
     */
    public function restore(User $user, OnlineCategory $model)
    {
        return false;
    }

    /**
     * Determine whether the onlineCategory can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OnlineCategory  $model
     * @return mixed
     */
    public function forceDelete(User $user, OnlineCategory $model)
    {
        return false;
    }
}
