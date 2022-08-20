<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SalesOrderEmployee;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalesOrderEmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the salesOrderEmployee can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list salesorderemployees');
    }

    /**
     * Determine whether the salesOrderEmployee can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SalesOrderEmployee  $model
     * @return mixed
     */
    public function view(User $user, SalesOrderEmployee $model)
    {
        return $user->hasPermissionTo('view salesorderemployees');
    }

    /**
     * Determine whether the salesOrderEmployee can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create salesorderemployees');
    }

    /**
     * Determine whether the salesOrderEmployee can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SalesOrderEmployee  $model
     * @return mixed
     */
    public function update(User $user, SalesOrderEmployee $model)
    {
        return $user->hasPermissionTo('update salesorderemployees');
    }

    /**
     * Determine whether the salesOrderEmployee can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SalesOrderEmployee  $model
     * @return mixed
     */
    public function delete(User $user, SalesOrderEmployee $model)
    {
        return $user->hasPermissionTo('delete salesorderemployees');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SalesOrderEmployee  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete salesorderemployees');
    }

    /**
     * Determine whether the salesOrderEmployee can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SalesOrderEmployee  $model
     * @return mixed
     */
    public function restore(User $user, SalesOrderEmployee $model)
    {
        return false;
    }

    /**
     * Determine whether the salesOrderEmployee can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SalesOrderEmployee  $model
     * @return mixed
     */
    public function forceDelete(User $user, SalesOrderEmployee $model)
    {
        return false;
    }
}
