<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductionFrom;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductionFromPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productionFrom can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list productionfroms');
    }

    /**
     * Determine whether the productionFrom can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionFrom  $model
     * @return mixed
     */
    public function view(User $user, ProductionFrom $model)
    {
        return $user->hasPermissionTo('view productionfroms');
    }

    /**
     * Determine whether the productionFrom can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create productionfroms');
    }

    /**
     * Determine whether the productionFrom can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionFrom  $model
     * @return mixed
     */
    public function update(User $user, ProductionFrom $model)
    {
        return $user->hasPermissionTo('update productionfroms');
    }

    /**
     * Determine whether the productionFrom can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionFrom  $model
     * @return mixed
     */
    public function delete(User $user, ProductionFrom $model)
    {
        return $user->hasPermissionTo('delete productionfroms');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionFrom  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete productionfroms');
    }

    /**
     * Determine whether the productionFrom can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionFrom  $model
     * @return mixed
     */
    public function restore(User $user, ProductionFrom $model)
    {
        return false;
    }

    /**
     * Determine whether the productionFrom can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductionFrom  $model
     * @return mixed
     */
    public function forceDelete(User $user, ProductionFrom $model)
    {
        return false;
    }
}
