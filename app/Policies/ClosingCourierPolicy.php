<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClosingCourier;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClosingCourierPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the closingCourier can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list closingcouriers');
    }

    /**
     * Determine whether the closingCourier can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ClosingCourier  $model
     * @return mixed
     */
    public function view(User $user, ClosingCourier $model)
    {
        return $user->hasPermissionTo('view closingcouriers');
    }

    /**
     * Determine whether the closingCourier can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create closingcouriers');
    }

    /**
     * Determine whether the closingCourier can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ClosingCourier  $model
     * @return mixed
     */
    public function update(User $user, ClosingCourier $model)
    {
        return $user->hasPermissionTo('update closingcouriers');
    }

    /**
     * Determine whether the closingCourier can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ClosingCourier  $model
     * @return mixed
     */
    public function delete(User $user, ClosingCourier $model)
    {
        return $user->hasPermissionTo('delete closingcouriers');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ClosingCourier  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete closingcouriers');
    }

    /**
     * Determine whether the closingCourier can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ClosingCourier  $model
     * @return mixed
     */
    public function restore(User $user, ClosingCourier $model)
    {
        return false;
    }

    /**
     * Determine whether the closingCourier can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ClosingCourier  $model
     * @return mixed
     */
    public function forceDelete(User $user, ClosingCourier $model)
    {
        return false;
    }
}
