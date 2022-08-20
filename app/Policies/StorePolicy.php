<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Store;
use Illuminate\Auth\Access\HandlesAuthorization;

class StorePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the store can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list stores');
    }

    /**
     * Determine whether the store can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Store  $model
     * @return mixed
     */
    public function view(User $user, Store $model)
    {
        return $user->hasPermissionTo('view stores');
    }

    /**
     * Determine whether the store can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create stores');
    }

    /**
     * Determine whether the store can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Store  $model
     * @return mixed
     */
    public function update(User $user, Store $model)
    {
        return $user->hasPermissionTo('update stores');
    }

    /**
     * Determine whether the store can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Store  $model
     * @return mixed
     */
    public function delete(User $user, Store $model)
    {
        return $user->hasPermissionTo('delete stores');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Store  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete stores');
    }

    /**
     * Determine whether the store can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Store  $model
     * @return mixed
     */
    public function restore(User $user, Store $model)
    {
        return false;
    }

    /**
     * Determine whether the store can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Store  $model
     * @return mixed
     */
    public function forceDelete(User $user, Store $model)
    {
        return false;
    }
}
