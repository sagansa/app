<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OutInProduct;
use Illuminate\Auth\Access\HandlesAuthorization;

class OutInProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the outInProduct can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list outinproducts');
    }

    /**
     * Determine whether the outInProduct can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OutInProduct  $model
     * @return mixed
     */
    public function view(User $user, OutInProduct $model)
    {
        return $user->hasPermissionTo('view outinproducts');
    }

    /**
     * Determine whether the outInProduct can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create outinproducts');
    }

    /**
     * Determine whether the outInProduct can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OutInProduct  $model
     * @return mixed
     */
    public function update(User $user, OutInProduct $model)
    {
        return $user->hasPermissionTo('update outinproducts');
    }

    /**
     * Determine whether the outInProduct can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OutInProduct  $model
     * @return mixed
     */
    public function delete(User $user, OutInProduct $model)
    {
        return $user->hasPermissionTo('delete outinproducts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OutInProduct  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete outinproducts');
    }

    /**
     * Determine whether the outInProduct can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OutInProduct  $model
     * @return mixed
     */
    public function restore(User $user, OutInProduct $model)
    {
        return false;
    }

    /**
     * Determine whether the outInProduct can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OutInProduct  $model
     * @return mixed
     */
    public function forceDelete(User $user, OutInProduct $model)
    {
        return false;
    }
}
