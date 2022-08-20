<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FranchiseGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class FranchiseGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the franchiseGroup can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list franchisegroups');
    }

    /**
     * Determine whether the franchiseGroup can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FranchiseGroup  $model
     * @return mixed
     */
    public function view(User $user, FranchiseGroup $model)
    {
        return $user->hasPermissionTo('view franchisegroups');
    }

    /**
     * Determine whether the franchiseGroup can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create franchisegroups');
    }

    /**
     * Determine whether the franchiseGroup can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FranchiseGroup  $model
     * @return mixed
     */
    public function update(User $user, FranchiseGroup $model)
    {
        return $user->hasPermissionTo('update franchisegroups');
    }

    /**
     * Determine whether the franchiseGroup can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FranchiseGroup  $model
     * @return mixed
     */
    public function delete(User $user, FranchiseGroup $model)
    {
        return $user->hasPermissionTo('delete franchisegroups');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FranchiseGroup  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete franchisegroups');
    }

    /**
     * Determine whether the franchiseGroup can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FranchiseGroup  $model
     * @return mixed
     */
    public function restore(User $user, FranchiseGroup $model)
    {
        return false;
    }

    /**
     * Determine whether the franchiseGroup can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FranchiseGroup  $model
     * @return mixed
     */
    public function forceDelete(User $user, FranchiseGroup $model)
    {
        return false;
    }
}
