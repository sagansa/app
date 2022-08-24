<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AccountCashless;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountCashlessPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the accountCashless can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list accountcashlesses');
    }

    /**
     * Determine whether the accountCashless can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AccountCashless  $model
     * @return mixed
     */
    public function view(User $user, AccountCashless $model)
    {
        return $user->hasPermissionTo('view accountcashlesses');
    }

    /**
     * Determine whether the accountCashless can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create accountcashlesses');
    }

    /**
     * Determine whether the accountCashless can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AccountCashless  $model
     * @return mixed
     */
    public function update(User $user, AccountCashless $model)
    {
        return $user->hasPermissionTo('update accountcashlesses');
    }

    /**
     * Determine whether the accountCashless can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AccountCashless  $model
     * @return mixed
     */
    public function delete(User $user, AccountCashless $model)
    {
        return $user->hasPermissionTo('delete accountcashlesses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AccountCashless  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete accountcashlesses');
    }

    /**
     * Determine whether the accountCashless can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AccountCashless  $model
     * @return mixed
     */
    public function restore(User $user, AccountCashless $model)
    {
        return false;
    }

    /**
     * Determine whether the accountCashless can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\AccountCashless  $model
     * @return mixed
     */
    public function forceDelete(User $user, AccountCashless $model)
    {
        return false;
    }
}
