<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RequestStock;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequestStockPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the requestStock can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list requeststocks');
    }

    /**
     * Determine whether the requestStock can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RequestStock  $model
     * @return mixed
     */
    public function view(User $user, RequestStock $model)
    {
        return $user->hasPermissionTo('view requeststocks');
    }

    /**
     * Determine whether the requestStock can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create requeststocks');
    }

    /**
     * Determine whether the requestStock can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RequestStock  $model
     * @return mixed
     */
    public function update(User $user, RequestStock $model)
    {
        return $user->hasPermissionTo('update requeststocks');
    }

    /**
     * Determine whether the requestStock can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RequestStock  $model
     * @return mixed
     */
    public function delete(User $user, RequestStock $model)
    {
        return $user->hasPermissionTo('delete requeststocks');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RequestStock  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete requeststocks');
    }

    /**
     * Determine whether the requestStock can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RequestStock  $model
     * @return mixed
     */
    public function restore(User $user, RequestStock $model)
    {
        return false;
    }

    /**
     * Determine whether the requestStock can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\RequestStock  $model
     * @return mixed
     */
    public function forceDelete(User $user, RequestStock $model)
    {
        return false;
    }
}
