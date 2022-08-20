<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserCashless;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserCashlessPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the userCashless can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list usercashlesses');
    }

    /**
     * Determine whether the userCashless can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UserCashless  $model
     * @return mixed
     */
    public function view(User $user, UserCashless $model)
    {
        return $user->hasPermissionTo('view usercashlesses');
    }

    /**
     * Determine whether the userCashless can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create usercashlesses');
    }

    /**
     * Determine whether the userCashless can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UserCashless  $model
     * @return mixed
     */
    public function update(User $user, UserCashless $model)
    {
        return $user->hasPermissionTo('update usercashlesses');
    }

    /**
     * Determine whether the userCashless can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UserCashless  $model
     * @return mixed
     */
    public function delete(User $user, UserCashless $model)
    {
        return $user->hasPermissionTo('delete usercashlesses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UserCashless  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete usercashlesses');
    }

    /**
     * Determine whether the userCashless can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UserCashless  $model
     * @return mixed
     */
    public function restore(User $user, UserCashless $model)
    {
        return false;
    }

    /**
     * Determine whether the userCashless can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UserCashless  $model
     * @return mixed
     */
    public function forceDelete(User $user, UserCashless $model)
    {
        return false;
    }
}
