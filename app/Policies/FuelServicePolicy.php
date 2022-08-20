<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FuelService;
use Illuminate\Auth\Access\HandlesAuthorization;

class FuelServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the fuelService can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list fuelservices');
    }

    /**
     * Determine whether the fuelService can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FuelService  $model
     * @return mixed
     */
    public function view(User $user, FuelService $model)
    {
        return $user->hasPermissionTo('view fuelservices');
    }

    /**
     * Determine whether the fuelService can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create fuelservices');
    }

    /**
     * Determine whether the fuelService can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FuelService  $model
     * @return mixed
     */
    public function update(User $user, FuelService $model)
    {
        return $user->hasPermissionTo('update fuelservices');
    }

    /**
     * Determine whether the fuelService can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FuelService  $model
     * @return mixed
     */
    public function delete(User $user, FuelService $model)
    {
        return $user->hasPermissionTo('delete fuelservices');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FuelService  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete fuelservices');
    }

    /**
     * Determine whether the fuelService can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FuelService  $model
     * @return mixed
     */
    public function restore(User $user, FuelService $model)
    {
        return false;
    }

    /**
     * Determine whether the fuelService can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FuelService  $model
     * @return mixed
     */
    public function forceDelete(User $user, FuelService $model)
    {
        return false;
    }
}
