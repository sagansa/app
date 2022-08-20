<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StoreAsset;
use Illuminate\Auth\Access\HandlesAuthorization;

class StoreAssetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the storeAsset can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list storeassets');
    }

    /**
     * Determine whether the storeAsset can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\StoreAsset  $model
     * @return mixed
     */
    public function view(User $user, StoreAsset $model)
    {
        return $user->hasPermissionTo('view storeassets');
    }

    /**
     * Determine whether the storeAsset can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create storeassets');
    }

    /**
     * Determine whether the storeAsset can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\StoreAsset  $model
     * @return mixed
     */
    public function update(User $user, StoreAsset $model)
    {
        return $user->hasPermissionTo('update storeassets');
    }

    /**
     * Determine whether the storeAsset can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\StoreAsset  $model
     * @return mixed
     */
    public function delete(User $user, StoreAsset $model)
    {
        return $user->hasPermissionTo('delete storeassets');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\StoreAsset  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete storeassets');
    }

    /**
     * Determine whether the storeAsset can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\StoreAsset  $model
     * @return mixed
     */
    public function restore(User $user, StoreAsset $model)
    {
        return false;
    }

    /**
     * Determine whether the storeAsset can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\StoreAsset  $model
     * @return mixed
     */
    public function forceDelete(User $user, StoreAsset $model)
    {
        return false;
    }
}
