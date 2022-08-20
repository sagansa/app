<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VehicleTax;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehicleTaxPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the vehicleTax can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list vehicletaxes');
    }

    /**
     * Determine whether the vehicleTax can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\VehicleTax  $model
     * @return mixed
     */
    public function view(User $user, VehicleTax $model)
    {
        return $user->hasPermissionTo('view vehicletaxes');
    }

    /**
     * Determine whether the vehicleTax can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create vehicletaxes');
    }

    /**
     * Determine whether the vehicleTax can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\VehicleTax  $model
     * @return mixed
     */
    public function update(User $user, VehicleTax $model)
    {
        return $user->hasPermissionTo('update vehicletaxes');
    }

    /**
     * Determine whether the vehicleTax can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\VehicleTax  $model
     * @return mixed
     */
    public function delete(User $user, VehicleTax $model)
    {
        return $user->hasPermissionTo('delete vehicletaxes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\VehicleTax  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete vehicletaxes');
    }

    /**
     * Determine whether the vehicleTax can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\VehicleTax  $model
     * @return mixed
     */
    public function restore(User $user, VehicleTax $model)
    {
        return false;
    }

    /**
     * Determine whether the vehicleTax can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\VehicleTax  $model
     * @return mixed
     */
    public function forceDelete(User $user, VehicleTax $model)
    {
        return false;
    }
}
