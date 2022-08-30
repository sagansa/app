<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TransferFuelService;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransferFuelServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the transferFuelService can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list transferfuelservices');
    }

    /**
     * Determine whether the transferFuelService can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TransferFuelService  $model
     * @return mixed
     */
    public function view(User $user, TransferFuelService $model)
    {
        return $user->hasPermissionTo('view transferfuelservices');
    }

    /**
     * Determine whether the transferFuelService can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create transferfuelservices');
    }

    /**
     * Determine whether the transferFuelService can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TransferFuelService  $model
     * @return mixed
     */
    public function update(User $user, TransferFuelService $model)
    {
        return $user->hasPermissionTo('update transferfuelservices');
    }

    /**
     * Determine whether the transferFuelService can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TransferFuelService  $model
     * @return mixed
     */
    public function delete(User $user, TransferFuelService $model)
    {
        return $user->hasPermissionTo('delete transferfuelservices');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TransferFuelService  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete transferfuelservices');
    }

    /**
     * Determine whether the transferFuelService can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TransferFuelService  $model
     * @return mixed
     */
    public function restore(User $user, TransferFuelService $model)
    {
        return false;
    }

    /**
     * Determine whether the transferFuelService can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TransferFuelService  $model
     * @return mixed
     */
    public function forceDelete(User $user, TransferFuelService $model)
    {
        return false;
    }
}
