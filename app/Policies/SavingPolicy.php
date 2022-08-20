<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Saving;
use Illuminate\Auth\Access\HandlesAuthorization;

class SavingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the saving can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list savings');
    }

    /**
     * Determine whether the saving can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Saving  $model
     * @return mixed
     */
    public function view(User $user, Saving $model)
    {
        return $user->hasPermissionTo('view savings');
    }

    /**
     * Determine whether the saving can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create savings');
    }

    /**
     * Determine whether the saving can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Saving  $model
     * @return mixed
     */
    public function update(User $user, Saving $model)
    {
        return $user->hasPermissionTo('update savings');
    }

    /**
     * Determine whether the saving can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Saving  $model
     * @return mixed
     */
    public function delete(User $user, Saving $model)
    {
        return $user->hasPermissionTo('delete savings');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Saving  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete savings');
    }

    /**
     * Determine whether the saving can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Saving  $model
     * @return mixed
     */
    public function restore(User $user, Saving $model)
    {
        return false;
    }

    /**
     * Determine whether the saving can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Saving  $model
     * @return mixed
     */
    public function forceDelete(User $user, Saving $model)
    {
        return false;
    }
}
