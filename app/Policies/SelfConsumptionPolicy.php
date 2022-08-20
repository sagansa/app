<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SelfConsumption;
use Illuminate\Auth\Access\HandlesAuthorization;

class SelfConsumptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the selfConsumption can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list selfconsumptions');
    }

    /**
     * Determine whether the selfConsumption can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SelfConsumption  $model
     * @return mixed
     */
    public function view(User $user, SelfConsumption $model)
    {
        return $user->hasPermissionTo('view selfconsumptions');
    }

    /**
     * Determine whether the selfConsumption can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create selfconsumptions');
    }

    /**
     * Determine whether the selfConsumption can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SelfConsumption  $model
     * @return mixed
     */
    public function update(User $user, SelfConsumption $model)
    {
        return $user->hasPermissionTo('update selfconsumptions');
    }

    /**
     * Determine whether the selfConsumption can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SelfConsumption  $model
     * @return mixed
     */
    public function delete(User $user, SelfConsumption $model)
    {
        return $user->hasPermissionTo('delete selfconsumptions');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SelfConsumption  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete selfconsumptions');
    }

    /**
     * Determine whether the selfConsumption can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SelfConsumption  $model
     * @return mixed
     */
    public function restore(User $user, SelfConsumption $model)
    {
        return false;
    }

    /**
     * Determine whether the selfConsumption can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SelfConsumption  $model
     * @return mixed
     */
    public function forceDelete(User $user, SelfConsumption $model)
    {
        return false;
    }
}
