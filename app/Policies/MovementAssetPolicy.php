<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MovementAsset;
use Illuminate\Auth\Access\HandlesAuthorization;

class MovementAssetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the movementAsset can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list movementassets');
    }

    /**
     * Determine whether the movementAsset can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MovementAsset  $model
     * @return mixed
     */
    public function view(User $user, MovementAsset $model)
    {
        return $user->hasPermissionTo('view movementassets');
    }

    /**
     * Determine whether the movementAsset can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create movementassets');
    }

    /**
     * Determine whether the movementAsset can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MovementAsset  $model
     * @return mixed
     */
    public function update(User $user, MovementAsset $model)
    {
        return $user->hasPermissionTo('update movementassets');
    }

    /**
     * Determine whether the movementAsset can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MovementAsset  $model
     * @return mixed
     */
    public function delete(User $user, MovementAsset $model)
    {
        return $user->hasPermissionTo('delete movementassets');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MovementAsset  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete movementassets');
    }

    /**
     * Determine whether the movementAsset can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MovementAsset  $model
     * @return mixed
     */
    public function restore(User $user, MovementAsset $model)
    {
        return false;
    }

    /**
     * Determine whether the movementAsset can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MovementAsset  $model
     * @return mixed
     */
    public function forceDelete(User $user, MovementAsset $model)
    {
        return false;
    }
}
