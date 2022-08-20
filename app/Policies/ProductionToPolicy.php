<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductionTo;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductionToPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productionTo can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list productiontos');
    }

    /**
     * Determine whether the productionTo can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionTo  $model
     * @return mixed
     */
    public function view(User $user, ProductionTo $model)
    {
        return $user->hasPermissionTo('view productiontos');
    }

    /**
     * Determine whether the productionTo can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create productiontos');
    }

    /**
     * Determine whether the productionTo can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionTo  $model
     * @return mixed
     */
    public function update(User $user, ProductionTo $model)
    {
        return $user->hasPermissionTo('update productiontos');
    }

    /**
     * Determine whether the productionTo can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionTo  $model
     * @return mixed
     */
    public function delete(User $user, ProductionTo $model)
    {
        return $user->hasPermissionTo('delete productiontos');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionTo  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete productiontos');
    }

    /**
     * Determine whether the productionTo can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionTo  $model
     * @return mixed
     */
    public function restore(User $user, ProductionTo $model)
    {
        return false;
    }

    /**
     * Determine whether the productionTo can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionTo  $model
     * @return mixed
     */
    public function forceDelete(User $user, ProductionTo $model)
    {
        return false;
    }
}
