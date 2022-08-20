<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ShiftStore;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShiftStorePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the shiftStore can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list shiftstores');
    }

    /**
     * Determine whether the shiftStore can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ShiftStore  $model
     * @return mixed
     */
    public function view(User $user, ShiftStore $model)
    {
        return $user->hasPermissionTo('view shiftstores');
    }

    /**
     * Determine whether the shiftStore can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create shiftstores');
    }

    /**
     * Determine whether the shiftStore can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ShiftStore  $model
     * @return mixed
     */
    public function update(User $user, ShiftStore $model)
    {
        return $user->hasPermissionTo('update shiftstores');
    }

    /**
     * Determine whether the shiftStore can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ShiftStore  $model
     * @return mixed
     */
    public function delete(User $user, ShiftStore $model)
    {
        return $user->hasPermissionTo('delete shiftstores');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ShiftStore  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete shiftstores');
    }

    /**
     * Determine whether the shiftStore can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ShiftStore  $model
     * @return mixed
     */
    public function restore(User $user, ShiftStore $model)
    {
        return false;
    }

    /**
     * Determine whether the shiftStore can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ShiftStore  $model
     * @return mixed
     */
    public function forceDelete(User $user, ShiftStore $model)
    {
        return false;
    }
}
