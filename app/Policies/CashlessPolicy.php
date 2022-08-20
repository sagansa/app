<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cashless;
use Illuminate\Auth\Access\HandlesAuthorization;

class CashlessPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the cashless can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list cashlesses');
    }

    /**
     * Determine whether the cashless can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Cashless  $model
     * @return mixed
     */
    public function view(User $user, Cashless $model)
    {
        return $user->hasPermissionTo('view cashlesses');
    }

    /**
     * Determine whether the cashless can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create cashlesses');
    }

    /**
     * Determine whether the cashless can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Cashless  $model
     * @return mixed
     */
    public function update(User $user, Cashless $model)
    {
        return $user->hasPermissionTo('update cashlesses');
    }

    /**
     * Determine whether the cashless can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Cashless  $model
     * @return mixed
     */
    public function delete(User $user, Cashless $model)
    {
        return $user->hasPermissionTo('delete cashlesses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Cashless  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete cashlesses');
    }

    /**
     * Determine whether the cashless can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Cashless  $model
     * @return mixed
     */
    public function restore(User $user, Cashless $model)
    {
        return false;
    }

    /**
     * Determine whether the cashless can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Cashless  $model
     * @return mixed
     */
    public function forceDelete(User $user, Cashless $model)
    {
        return false;
    }
}
