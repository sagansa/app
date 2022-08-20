<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MonthlySalary;
use Illuminate\Auth\Access\HandlesAuthorization;

class MonthlySalaryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the monthlySalary can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list monthlysalaries');
    }

    /**
     * Determine whether the monthlySalary can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MonthlySalary  $model
     * @return mixed
     */
    public function view(User $user, MonthlySalary $model)
    {
        return $user->hasPermissionTo('view monthlysalaries');
    }

    /**
     * Determine whether the monthlySalary can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create monthlysalaries');
    }

    /**
     * Determine whether the monthlySalary can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MonthlySalary  $model
     * @return mixed
     */
    public function update(User $user, MonthlySalary $model)
    {
        return $user->hasPermissionTo('update monthlysalaries');
    }

    /**
     * Determine whether the monthlySalary can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MonthlySalary  $model
     * @return mixed
     */
    public function delete(User $user, MonthlySalary $model)
    {
        return $user->hasPermissionTo('delete monthlysalaries');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MonthlySalary  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete monthlysalaries');
    }

    /**
     * Determine whether the monthlySalary can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MonthlySalary  $model
     * @return mixed
     */
    public function restore(User $user, MonthlySalary $model)
    {
        return false;
    }

    /**
     * Determine whether the monthlySalary can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MonthlySalary  $model
     * @return mixed
     */
    public function forceDelete(User $user, MonthlySalary $model)
    {
        return false;
    }
}
