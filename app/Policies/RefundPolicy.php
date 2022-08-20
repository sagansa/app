<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Refund;
use Illuminate\Auth\Access\HandlesAuthorization;

class RefundPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the refund can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list refunds');
    }

    /**
     * Determine whether the refund can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Refund  $model
     * @return mixed
     */
    public function view(User $user, Refund $model)
    {
        return $user->hasPermissionTo('view refunds');
    }

    /**
     * Determine whether the refund can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create refunds');
    }

    /**
     * Determine whether the refund can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Refund  $model
     * @return mixed
     */
    public function update(User $user, Refund $model)
    {
        return $user->hasPermissionTo('update refunds');
    }

    /**
     * Determine whether the refund can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Refund  $model
     * @return mixed
     */
    public function delete(User $user, Refund $model)
    {
        return $user->hasPermissionTo('delete refunds');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Refund  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete refunds');
    }

    /**
     * Determine whether the refund can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Refund  $model
     * @return mixed
     */
    public function restore(User $user, Refund $model)
    {
        return false;
    }

    /**
     * Determine whether the refund can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Refund  $model
     * @return mixed
     */
    public function forceDelete(User $user, Refund $model)
    {
        return false;
    }
}
