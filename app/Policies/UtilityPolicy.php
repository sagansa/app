<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Utility;
use Illuminate\Auth\Access\HandlesAuthorization;

class UtilityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the utility can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list utilities');
    }

    /**
     * Determine whether the utility can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Utility  $model
     * @return mixed
     */
    public function view(User $user, Utility $model)
    {
        return $user->hasPermissionTo('view utilities');
    }

    /**
     * Determine whether the utility can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create utilities');
    }

    /**
     * Determine whether the utility can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Utility  $model
     * @return mixed
     */
    public function update(User $user, Utility $model)
    {
        return $user->hasPermissionTo('update utilities');
    }

    /**
     * Determine whether the utility can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Utility  $model
     * @return mixed
     */
    public function delete(User $user, Utility $model)
    {
        return $user->hasPermissionTo('delete utilities');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Utility  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete utilities');
    }

    /**
     * Determine whether the utility can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Utility  $model
     * @return mixed
     */
    public function restore(User $user, Utility $model)
    {
        return false;
    }

    /**
     * Determine whether the utility can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Utility  $model
     * @return mixed
     */
    public function forceDelete(User $user, Utility $model)
    {
        return false;
    }
}
