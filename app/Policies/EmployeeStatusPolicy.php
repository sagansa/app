<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeStatus;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeeStatusPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the employeeStatus can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list employeestatuses');
    }

    /**
     * Determine whether the employeeStatus can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\EmployeeStatus  $model
     * @return mixed
     */
    public function view(User $user, EmployeeStatus $model)
    {
        return $user->hasPermissionTo('view employeestatuses');
    }

    /**
     * Determine whether the employeeStatus can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create employeestatuses');
    }

    /**
     * Determine whether the employeeStatus can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\EmployeeStatus  $model
     * @return mixed
     */
    public function update(User $user, EmployeeStatus $model)
    {
        return $user->hasPermissionTo('update employeestatuses');
    }

    /**
     * Determine whether the employeeStatus can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\EmployeeStatus  $model
     * @return mixed
     */
    public function delete(User $user, EmployeeStatus $model)
    {
        return $user->hasPermissionTo('delete employeestatuses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\EmployeeStatus  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete employeestatuses');
    }

    /**
     * Determine whether the employeeStatus can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\EmployeeStatus  $model
     * @return mixed
     */
    public function restore(User $user, EmployeeStatus $model)
    {
        return false;
    }

    /**
     * Determine whether the employeeStatus can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\EmployeeStatus  $model
     * @return mixed
     */
    public function forceDelete(User $user, EmployeeStatus $model)
    {
        return false;
    }
}
