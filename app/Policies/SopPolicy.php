<?php

namespace App\Policies;

use App\Models\Sop;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SopPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the sop can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list sops');
    }

    /**
     * Determine whether the sop can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Sop  $model
     * @return mixed
     */
    public function view(User $user, Sop $model)
    {
        return $user->hasPermissionTo('view sops');
    }

    /**
     * Determine whether the sop can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create sops');
    }

    /**
     * Determine whether the sop can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Sop  $model
     * @return mixed
     */
    public function update(User $user, Sop $model)
    {
        return $user->hasPermissionTo('update sops');
    }

    /**
     * Determine whether the sop can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Sop  $model
     * @return mixed
     */
    public function delete(User $user, Sop $model)
    {
        return $user->hasPermissionTo('delete sops');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Sop  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete sops');
    }

    /**
     * Determine whether the sop can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Sop  $model
     * @return mixed
     */
    public function restore(User $user, Sop $model)
    {
        return false;
    }

    /**
     * Determine whether the sop can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Sop  $model
     * @return mixed
     */
    public function forceDelete(User $user, Sop $model)
    {
        return false;
    }
}
