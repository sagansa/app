<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UtilityBill;
use Illuminate\Auth\Access\HandlesAuthorization;

class UtilityBillPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the utilityBill can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list utilitybills');
    }

    /**
     * Determine whether the utilityBill can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtilityBill  $model
     * @return mixed
     */
    public function view(User $user, UtilityBill $model)
    {
        return $user->hasPermissionTo('view utilitybills');
    }

    /**
     * Determine whether the utilityBill can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create utilitybills');
    }

    /**
     * Determine whether the utilityBill can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtilityBill  $model
     * @return mixed
     */
    public function update(User $user, UtilityBill $model)
    {
        return $user->hasPermissionTo('update utilitybills');
    }

    /**
     * Determine whether the utilityBill can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtilityBill  $model
     * @return mixed
     */
    public function delete(User $user, UtilityBill $model)
    {
        return $user->hasPermissionTo('delete utilitybills');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtilityBill  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete utilitybills');
    }

    /**
     * Determine whether the utilityBill can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtilityBill  $model
     * @return mixed
     */
    public function restore(User $user, UtilityBill $model)
    {
        return false;
    }

    /**
     * Determine whether the utilityBill can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtilityBill  $model
     * @return mixed
     */
    public function forceDelete(User $user, UtilityBill $model)
    {
        return false;
    }
}
