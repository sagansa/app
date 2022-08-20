<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Presence;
use Illuminate\Auth\Access\HandlesAuthorization;

class PresencePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the presence can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list presences');
    }

    /**
     * Determine whether the presence can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Presence  $model
     * @return mixed
     */
    public function view(User $user, Presence $model)
    {
        return $user->hasPermissionTo('view presences');
    }

    /**
     * Determine whether the presence can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create presences');
    }

    /**
     * Determine whether the presence can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Presence  $model
     * @return mixed
     */
    public function update(User $user, Presence $model)
    {
        return $user->hasPermissionTo('update presences');
    }

    /**
     * Determine whether the presence can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Presence  $model
     * @return mixed
     */
    public function delete(User $user, Presence $model)
    {
        return $user->hasPermissionTo('delete presences');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Presence  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete presences');
    }

    /**
     * Determine whether the presence can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Presence  $model
     * @return mixed
     */
    public function restore(User $user, Presence $model)
    {
        return false;
    }

    /**
     * Determine whether the presence can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Presence  $model
     * @return mixed
     */
    public function forceDelete(User $user, Presence $model)
    {
        return false;
    }
}
