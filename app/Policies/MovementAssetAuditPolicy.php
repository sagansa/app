<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MovementAssetAudit;
use Illuminate\Auth\Access\HandlesAuthorization;

class MovementAssetAuditPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the movementAssetAudit can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list movementassetaudits');
    }

    /**
     * Determine whether the movementAssetAudit can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MovementAssetAudit  $model
     * @return mixed
     */
    public function view(User $user, MovementAssetAudit $model)
    {
        return $user->hasPermissionTo('view movementassetaudits');
    }

    /**
     * Determine whether the movementAssetAudit can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create movementassetaudits');
    }

    /**
     * Determine whether the movementAssetAudit can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MovementAssetAudit  $model
     * @return mixed
     */
    public function update(User $user, MovementAssetAudit $model)
    {
        return $user->hasPermissionTo('update movementassetaudits');
    }

    /**
     * Determine whether the movementAssetAudit can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MovementAssetAudit  $model
     * @return mixed
     */
    public function delete(User $user, MovementAssetAudit $model)
    {
        return $user->hasPermissionTo('delete movementassetaudits');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MovementAssetAudit  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete movementassetaudits');
    }

    /**
     * Determine whether the movementAssetAudit can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MovementAssetAudit  $model
     * @return mixed
     */
    public function restore(User $user, MovementAssetAudit $model)
    {
        return false;
    }

    /**
     * Determine whether the movementAssetAudit can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MovementAssetAudit  $model
     * @return mixed
     */
    public function forceDelete(User $user, MovementAssetAudit $model)
    {
        return false;
    }
}
