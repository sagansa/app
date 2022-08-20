<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SalesOrderOnline;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalesOrderOnlinePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the salesOrderOnline can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list salesorderonlines');
    }

    /**
     * Determine whether the salesOrderOnline can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SalesOrderOnline  $model
     * @return mixed
     */
    public function view(User $user, SalesOrderOnline $model)
    {
        return $user->hasPermissionTo('view salesorderonlines');
    }

    /**
     * Determine whether the salesOrderOnline can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create salesorderonlines');
    }

    /**
     * Determine whether the salesOrderOnline can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SalesOrderOnline  $model
     * @return mixed
     */
    public function update(User $user, SalesOrderOnline $model)
    {
        return $user->hasPermissionTo('update salesorderonlines');
    }

    /**
     * Determine whether the salesOrderOnline can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SalesOrderOnline  $model
     * @return mixed
     */
    public function delete(User $user, SalesOrderOnline $model)
    {
        return $user->hasPermissionTo('delete salesorderonlines');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SalesOrderOnline  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete salesorderonlines');
    }

    /**
     * Determine whether the salesOrderOnline can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SalesOrderOnline  $model
     * @return mixed
     */
    public function restore(User $user, SalesOrderOnline $model)
    {
        return false;
    }

    /**
     * Determine whether the salesOrderOnline can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SalesOrderOnline  $model
     * @return mixed
     */
    public function forceDelete(User $user, SalesOrderOnline $model)
    {
        return false;
    }
}
