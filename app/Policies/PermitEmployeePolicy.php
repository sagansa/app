<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PermitEmployee;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermitEmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the permitEmployee can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list permitemployees');
    }

    /**
     * Determine whether the permitEmployee can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PermitEmployee  $model
     * @return mixed
     */
    public function view(User $user, PermitEmployee $model)
    {
        return $user->hasPermissionTo('view permitemployees');
    }

    /**
     * Determine whether the permitEmployee can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create permitemployees');
    }

    /**
     * Determine whether the permitEmployee can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PermitEmployee  $model
     * @return mixed
     */
    public function update(User $user, PermitEmployee $model)
    {
        return $user->hasPermissionTo('update permitemployees');
    }

    /**
     * Determine whether the permitEmployee can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PermitEmployee  $model
     * @return mixed
     */
    public function delete(User $user, PermitEmployee $model)
    {
        return $user->hasPermissionTo('delete permitemployees');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PermitEmployee  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete permitemployees');
    }

    /**
     * Determine whether the permitEmployee can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PermitEmployee  $model
     * @return mixed
     */
    public function restore(User $user, PermitEmployee $model)
    {
        return false;
    }

    /**
     * Determine whether the permitEmployee can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PermitEmployee  $model
     * @return mixed
     */
    public function forceDelete(User $user, PermitEmployee $model)
    {
        return false;
    }
}
