<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StoreCashless;
use Illuminate\Auth\Access\HandlesAuthorization;

class StoreCashlessPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the storeCashless can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list storecashlesses');
    }

    /**
     * Determine whether the storeCashless can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\StoreCashless  $model
     * @return mixed
     */
    public function view(User $user, StoreCashless $model)
    {
        return $user->hasPermissionTo('view storecashlesses');
    }

    /**
     * Determine whether the storeCashless can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create storecashlesses');
    }

    /**
     * Determine whether the storeCashless can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\StoreCashless  $model
     * @return mixed
     */
    public function update(User $user, StoreCashless $model)
    {
        return $user->hasPermissionTo('update storecashlesses');
    }

    /**
     * Determine whether the storeCashless can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\StoreCashless  $model
     * @return mixed
     */
    public function delete(User $user, StoreCashless $model)
    {
        return $user->hasPermissionTo('delete storecashlesses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\StoreCashless  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete storecashlesses');
    }

    /**
     * Determine whether the storeCashless can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\StoreCashless  $model
     * @return mixed
     */
    public function restore(User $user, StoreCashless $model)
    {
        return false;
    }

    /**
     * Determine whether the storeCashless can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\StoreCashless  $model
     * @return mixed
     */
    public function forceDelete(User $user, StoreCashless $model)
    {
        return false;
    }
}
