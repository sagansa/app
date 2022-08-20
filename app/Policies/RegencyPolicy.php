<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Regency;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegencyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the regency can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list regencies');
    }

    /**
     * Determine whether the regency can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Regency  $model
     * @return mixed
     */
    public function view(User $user, Regency $model)
    {
        return $user->hasPermissionTo('view regencies');
    }

    /**
     * Determine whether the regency can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create regencies');
    }

    /**
     * Determine whether the regency can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Regency  $model
     * @return mixed
     */
    public function update(User $user, Regency $model)
    {
        return $user->hasPermissionTo('update regencies');
    }

    /**
     * Determine whether the regency can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Regency  $model
     * @return mixed
     */
    public function delete(User $user, Regency $model)
    {
        return $user->hasPermissionTo('delete regencies');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Regency  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete regencies');
    }

    /**
     * Determine whether the regency can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Regency  $model
     * @return mixed
     */
    public function restore(User $user, Regency $model)
    {
        return false;
    }

    /**
     * Determine whether the regency can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Regency  $model
     * @return mixed
     */
    public function forceDelete(User $user, Regency $model)
    {
        return false;
    }
}
