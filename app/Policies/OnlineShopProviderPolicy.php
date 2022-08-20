<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OnlineShopProvider;
use Illuminate\Auth\Access\HandlesAuthorization;

class OnlineShopProviderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the onlineShopProvider can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list onlineshopproviders');
    }

    /**
     * Determine whether the onlineShopProvider can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OnlineShopProvider  $model
     * @return mixed
     */
    public function view(User $user, OnlineShopProvider $model)
    {
        return $user->hasPermissionTo('view onlineshopproviders');
    }

    /**
     * Determine whether the onlineShopProvider can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create onlineshopproviders');
    }

    /**
     * Determine whether the onlineShopProvider can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OnlineShopProvider  $model
     * @return mixed
     */
    public function update(User $user, OnlineShopProvider $model)
    {
        return $user->hasPermissionTo('update onlineshopproviders');
    }

    /**
     * Determine whether the onlineShopProvider can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OnlineShopProvider  $model
     * @return mixed
     */
    public function delete(User $user, OnlineShopProvider $model)
    {
        return $user->hasPermissionTo('delete onlineshopproviders');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OnlineShopProvider  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete onlineshopproviders');
    }

    /**
     * Determine whether the onlineShopProvider can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OnlineShopProvider  $model
     * @return mixed
     */
    public function restore(User $user, OnlineShopProvider $model)
    {
        return false;
    }

    /**
     * Determine whether the onlineShopProvider can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OnlineShopProvider  $model
     * @return mixed
     */
    public function forceDelete(User $user, OnlineShopProvider $model)
    {
        return false;
    }
}
