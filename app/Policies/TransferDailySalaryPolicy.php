<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TransferDailySalary;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransferDailySalaryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the transferDailySalary can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list transferdailysalaries');
    }

    /**
     * Determine whether the transferDailySalary can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TransferDailySalary  $model
     * @return mixed
     */
    public function view(User $user, TransferDailySalary $model)
    {
        return $user->hasPermissionTo('view transferdailysalaries');
    }

    /**
     * Determine whether the transferDailySalary can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create transferdailysalaries');
    }

    /**
     * Determine whether the transferDailySalary can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TransferDailySalary  $model
     * @return mixed
     */
    public function update(User $user, TransferDailySalary $model)
    {
        return $user->hasPermissionTo('update transferdailysalaries');
    }

    /**
     * Determine whether the transferDailySalary can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TransferDailySalary  $model
     * @return mixed
     */
    public function delete(User $user, TransferDailySalary $model)
    {
        return $user->hasPermissionTo('delete transferdailysalaries');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TransferDailySalary  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete transferdailysalaries');
    }

    /**
     * Determine whether the transferDailySalary can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TransferDailySalary  $model
     * @return mixed
     */
    public function restore(User $user, TransferDailySalary $model)
    {
        return false;
    }

    /**
     * Determine whether the transferDailySalary can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TransferDailySalary  $model
     * @return mixed
     */
    public function forceDelete(User $user, TransferDailySalary $model)
    {
        return false;
    }
}
