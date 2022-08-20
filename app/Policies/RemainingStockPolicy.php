<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RemainingStock;
use Illuminate\Auth\Access\HandlesAuthorization;

class RemainingStockPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the remainingStock can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list remainingstocks');
    }

    /**
     * Determine whether the remainingStock can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RemainingStock  $model
     * @return mixed
     */
    public function view(User $user, RemainingStock $model)
    {
        return $user->hasPermissionTo('view remainingstocks');
    }

    /**
     * Determine whether the remainingStock can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create remainingstocks');
    }

    /**
     * Determine whether the remainingStock can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RemainingStock  $model
     * @return mixed
     */
    public function update(User $user, RemainingStock $model)
    {
        return $user->hasPermissionTo('update remainingstocks');
    }

    /**
     * Determine whether the remainingStock can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RemainingStock  $model
     * @return mixed
     */
    public function delete(User $user, RemainingStock $model)
    {
        return $user->hasPermissionTo('delete remainingstocks');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RemainingStock  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete remainingstocks');
    }

    /**
     * Determine whether the remainingStock can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RemainingStock  $model
     * @return mixed
     */
    public function restore(User $user, RemainingStock $model)
    {
        return false;
    }

    /**
     * Determine whether the remainingStock can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RemainingStock  $model
     * @return mixed
     */
    public function forceDelete(User $user, RemainingStock $model)
    {
        return false;
    }
}
