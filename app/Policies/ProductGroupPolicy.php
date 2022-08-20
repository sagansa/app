<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productGroup can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list productgroups');
    }

    /**
     * Determine whether the productGroup can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductGroup  $model
     * @return mixed
     */
    public function view(User $user, ProductGroup $model)
    {
        return $user->hasPermissionTo('view productgroups');
    }

    /**
     * Determine whether the productGroup can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create productgroups');
    }

    /**
     * Determine whether the productGroup can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductGroup  $model
     * @return mixed
     */
    public function update(User $user, ProductGroup $model)
    {
        return $user->hasPermissionTo('update productgroups');
    }

    /**
     * Determine whether the productGroup can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductGroup  $model
     * @return mixed
     */
    public function delete(User $user, ProductGroup $model)
    {
        return $user->hasPermissionTo('delete productgroups');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductGroup  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete productgroups');
    }

    /**
     * Determine whether the productGroup can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductGroup  $model
     * @return mixed
     */
    public function restore(User $user, ProductGroup $model)
    {
        return false;
    }

    /**
     * Determine whether the productGroup can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductGroup  $model
     * @return mixed
     */
    public function forceDelete(User $user, ProductGroup $model)
    {
        return false;
    }
}
