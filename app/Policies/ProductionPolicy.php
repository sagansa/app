<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Production;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the production can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list productions');
    }

    /**
     * Determine whether the production can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Production  $model
     * @return mixed
     */
    public function view(User $user, Production $model)
    {
        return $user->hasPermissionTo('view productions');
    }

    /**
     * Determine whether the production can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create productions');
    }

    /**
     * Determine whether the production can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Production  $model
     * @return mixed
     */
    public function update(User $user, Production $model)
    {
        return $user->hasPermissionTo('update productions');
    }

    /**
     * Determine whether the production can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Production  $model
     * @return mixed
     */
    public function delete(User $user, Production $model)
    {
        return $user->hasPermissionTo('delete productions');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Production  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete productions');
    }

    /**
     * Determine whether the production can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Production  $model
     * @return mixed
     */
    public function restore(User $user, Production $model)
    {
        return false;
    }

    /**
     * Determine whether the production can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Production  $model
     * @return mixed
     */
    public function forceDelete(User $user, Production $model)
    {
        return false;
    }
}
