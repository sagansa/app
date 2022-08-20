<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ContractLocation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractLocationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the contractLocation can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list contractlocations');
    }

    /**
     * Determine whether the contractLocation can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ContractLocation  $model
     * @return mixed
     */
    public function view(User $user, ContractLocation $model)
    {
        return $user->hasPermissionTo('view contractlocations');
    }

    /**
     * Determine whether the contractLocation can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create contractlocations');
    }

    /**
     * Determine whether the contractLocation can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ContractLocation  $model
     * @return mixed
     */
    public function update(User $user, ContractLocation $model)
    {
        return $user->hasPermissionTo('update contractlocations');
    }

    /**
     * Determine whether the contractLocation can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ContractLocation  $model
     * @return mixed
     */
    public function delete(User $user, ContractLocation $model)
    {
        return $user->hasPermissionTo('delete contractlocations');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ContractLocation  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete contractlocations');
    }

    /**
     * Determine whether the contractLocation can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ContractLocation  $model
     * @return mixed
     */
    public function restore(User $user, ContractLocation $model)
    {
        return false;
    }

    /**
     * Determine whether the contractLocation can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ContractLocation  $model
     * @return mixed
     */
    public function forceDelete(User $user, ContractLocation $model)
    {
        return false;
    }
}
