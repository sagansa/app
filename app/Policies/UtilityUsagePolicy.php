<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UtilityUsage;
use Illuminate\Auth\Access\HandlesAuthorization;

class UtilityUsagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the utilityUsage can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list utilityusages');
    }

    /**
     * Determine whether the utilityUsage can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtilityUsage  $model
     * @return mixed
     */
    public function view(User $user, UtilityUsage $model)
    {
        return $user->hasPermissionTo('view utilityusages');
    }

    /**
     * Determine whether the utilityUsage can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create utilityusages');
    }

    /**
     * Determine whether the utilityUsage can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtilityUsage  $model
     * @return mixed
     */
    public function update(User $user, UtilityUsage $model)
    {
        return $user->hasPermissionTo('update utilityusages');
    }

    /**
     * Determine whether the utilityUsage can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtilityUsage  $model
     * @return mixed
     */
    public function delete(User $user, UtilityUsage $model)
    {
        return $user->hasPermissionTo('delete utilityusages');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtilityUsage  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete utilityusages');
    }

    /**
     * Determine whether the utilityUsage can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtilityUsage  $model
     * @return mixed
     */
    public function restore(User $user, UtilityUsage $model)
    {
        return false;
    }

    /**
     * Determine whether the utilityUsage can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtilityUsage  $model
     * @return mixed
     */
    public function forceDelete(User $user, UtilityUsage $model)
    {
        return false;
    }
}
