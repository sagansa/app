<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ContractEmployee;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractEmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the contractEmployee can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list contractemployees');
    }

    /**
     * Determine whether the contractEmployee can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ContractEmployee  $model
     * @return mixed
     */
    public function view(User $user, ContractEmployee $model)
    {
        return $user->hasPermissionTo('view contractemployees');
    }

    /**
     * Determine whether the contractEmployee can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create contractemployees');
    }

    /**
     * Determine whether the contractEmployee can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ContractEmployee  $model
     * @return mixed
     */
    public function update(User $user, ContractEmployee $model)
    {
        return $user->hasPermissionTo('update contractemployees');
    }

    /**
     * Determine whether the contractEmployee can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ContractEmployee  $model
     * @return mixed
     */
    public function delete(User $user, ContractEmployee $model)
    {
        return $user->hasPermissionTo('delete contractemployees');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ContractEmployee  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete contractemployees');
    }

    /**
     * Determine whether the contractEmployee can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ContractEmployee  $model
     * @return mixed
     */
    public function restore(User $user, ContractEmployee $model)
    {
        return false;
    }

    /**
     * Determine whether the contractEmployee can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ContractEmployee  $model
     * @return mixed
     */
    public function forceDelete(User $user, ContractEmployee $model)
    {
        return false;
    }
}
