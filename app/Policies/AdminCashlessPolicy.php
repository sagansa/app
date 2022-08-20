<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AdminCashless;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminCashlessPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the adminCashless can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list admincashlesses');
    }

    /**
     * Determine whether the adminCashless can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AdminCashless  $model
     * @return mixed
     */
    public function view(User $user, AdminCashless $model)
    {
        return $user->hasPermissionTo('view admincashlesses');
    }

    /**
     * Determine whether the adminCashless can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create admincashlesses');
    }

    /**
     * Determine whether the adminCashless can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AdminCashless  $model
     * @return mixed
     */
    public function update(User $user, AdminCashless $model)
    {
        return $user->hasPermissionTo('update admincashlesses');
    }

    /**
     * Determine whether the adminCashless can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AdminCashless  $model
     * @return mixed
     */
    public function delete(User $user, AdminCashless $model)
    {
        return $user->hasPermissionTo('delete admincashlesses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AdminCashless  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete admincashlesses');
    }

    /**
     * Determine whether the adminCashless can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AdminCashless  $model
     * @return mixed
     */
    public function restore(User $user, AdminCashless $model)
    {
        return false;
    }

    /**
     * Determine whether the adminCashless can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AdminCashless  $model
     * @return mixed
     */
    public function forceDelete(User $user, AdminCashless $model)
    {
        return false;
    }
}
