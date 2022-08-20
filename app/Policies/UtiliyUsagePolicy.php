<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UtiliyUsage;
use Illuminate\Auth\Access\HandlesAuthorization;

class UtiliyUsagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the utiliyUsage can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list utiliyusages');
    }

    /**
     * Determine whether the utiliyUsage can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtiliyUsage  $model
     * @return mixed
     */
    public function view(User $user, UtiliyUsage $model)
    {
        return $user->hasPermissionTo('view utiliyusages');
    }

    /**
     * Determine whether the utiliyUsage can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create utiliyusages');
    }

    /**
     * Determine whether the utiliyUsage can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtiliyUsage  $model
     * @return mixed
     */
    public function update(User $user, UtiliyUsage $model)
    {
        return $user->hasPermissionTo('update utiliyusages');
    }

    /**
     * Determine whether the utiliyUsage can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtiliyUsage  $model
     * @return mixed
     */
    public function delete(User $user, UtiliyUsage $model)
    {
        return $user->hasPermissionTo('delete utiliyusages');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtiliyUsage  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete utiliyusages');
    }

    /**
     * Determine whether the utiliyUsage can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtiliyUsage  $model
     * @return mixed
     */
    public function restore(User $user, UtiliyUsage $model)
    {
        return false;
    }

    /**
     * Determine whether the utiliyUsage can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\UtiliyUsage  $model
     * @return mixed
     */
    public function forceDelete(User $user, UtiliyUsage $model)
    {
        return false;
    }
}
