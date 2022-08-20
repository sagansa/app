<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MaterialGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaterialGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the materialGroup can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list materialgroups');
    }

    /**
     * Determine whether the materialGroup can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MaterialGroup  $model
     * @return mixed
     */
    public function view(User $user, MaterialGroup $model)
    {
        return $user->hasPermissionTo('view materialgroups');
    }

    /**
     * Determine whether the materialGroup can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create materialgroups');
    }

    /**
     * Determine whether the materialGroup can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MaterialGroup  $model
     * @return mixed
     */
    public function update(User $user, MaterialGroup $model)
    {
        return $user->hasPermissionTo('update materialgroups');
    }

    /**
     * Determine whether the materialGroup can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MaterialGroup  $model
     * @return mixed
     */
    public function delete(User $user, MaterialGroup $model)
    {
        return $user->hasPermissionTo('delete materialgroups');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MaterialGroup  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete materialgroups');
    }

    /**
     * Determine whether the materialGroup can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MaterialGroup  $model
     * @return mixed
     */
    public function restore(User $user, MaterialGroup $model)
    {
        return false;
    }

    /**
     * Determine whether the materialGroup can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MaterialGroup  $model
     * @return mixed
     */
    public function forceDelete(User $user, MaterialGroup $model)
    {
        return false;
    }
}
