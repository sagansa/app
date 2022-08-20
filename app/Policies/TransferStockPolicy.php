<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TransferStock;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransferStockPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the transferStock can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list transferstocks');
    }

    /**
     * Determine whether the transferStock can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TransferStock  $model
     * @return mixed
     */
    public function view(User $user, TransferStock $model)
    {
        return $user->hasPermissionTo('view transferstocks');
    }

    /**
     * Determine whether the transferStock can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create transferstocks');
    }

    /**
     * Determine whether the transferStock can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TransferStock  $model
     * @return mixed
     */
    public function update(User $user, TransferStock $model)
    {
        return $user->hasPermissionTo('update transferstocks');
    }

    /**
     * Determine whether the transferStock can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TransferStock  $model
     * @return mixed
     */
    public function delete(User $user, TransferStock $model)
    {
        return $user->hasPermissionTo('delete transferstocks');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TransferStock  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete transferstocks');
    }

    /**
     * Determine whether the transferStock can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TransferStock  $model
     * @return mixed
     */
    public function restore(User $user, TransferStock $model)
    {
        return false;
    }

    /**
     * Determine whether the transferStock can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TransferStock  $model
     * @return mixed
     */
    public function forceDelete(User $user, TransferStock $model)
    {
        return false;
    }
}
