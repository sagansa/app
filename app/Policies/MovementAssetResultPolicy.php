<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MovementAssetResult;
use Illuminate\Auth\Access\HandlesAuthorization;

class MovementAssetResultPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the movementAssetResult can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list movementassetresults');
    }

    /**
     * Determine whether the movementAssetResult can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MovementAssetResult  $model
     * @return mixed
     */
    public function view(User $user, MovementAssetResult $model)
    {
        return $user->hasPermissionTo('view movementassetresults');
    }

    /**
     * Determine whether the movementAssetResult can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create movementassetresults');
    }

    /**
     * Determine whether the movementAssetResult can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MovementAssetResult  $model
     * @return mixed
     */
    public function update(User $user, MovementAssetResult $model)
    {
        return $user->hasPermissionTo('update movementassetresults');
    }

    /**
     * Determine whether the movementAssetResult can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MovementAssetResult  $model
     * @return mixed
     */
    public function delete(User $user, MovementAssetResult $model)
    {
        return $user->hasPermissionTo('delete movementassetresults');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MovementAssetResult  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete movementassetresults');
    }

    /**
     * Determine whether the movementAssetResult can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MovementAssetResult  $model
     * @return mixed
     */
    public function restore(User $user, MovementAssetResult $model)
    {
        return false;
    }

    /**
     * Determine whether the movementAssetResult can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MovementAssetResult  $model
     * @return mixed
     */
    public function forceDelete(User $user, MovementAssetResult $model)
    {
        return false;
    }
}
