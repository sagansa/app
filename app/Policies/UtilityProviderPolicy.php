<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UtilityProvider;
use Illuminate\Auth\Access\HandlesAuthorization;

class UtilityProviderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the utilityProvider can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list utilityproviders');
    }

    /**
     * Determine whether the utilityProvider can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtilityProvider  $model
     * @return mixed
     */
    public function view(User $user, UtilityProvider $model)
    {
        return $user->hasPermissionTo('view utilityproviders');
    }

    /**
     * Determine whether the utilityProvider can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create utilityproviders');
    }

    /**
     * Determine whether the utilityProvider can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtilityProvider  $model
     * @return mixed
     */
    public function update(User $user, UtilityProvider $model)
    {
        return $user->hasPermissionTo('update utilityproviders');
    }

    /**
     * Determine whether the utilityProvider can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtilityProvider  $model
     * @return mixed
     */
    public function delete(User $user, UtilityProvider $model)
    {
        return $user->hasPermissionTo('delete utilityproviders');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtilityProvider  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete utilityproviders');
    }

    /**
     * Determine whether the utilityProvider can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtilityProvider  $model
     * @return mixed
     */
    public function restore(User $user, UtilityProvider $model)
    {
        return false;
    }

    /**
     * Determine whether the utilityProvider can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtilityProvider  $model
     * @return mixed
     */
    public function forceDelete(User $user, UtilityProvider $model)
    {
        return false;
    }
}
