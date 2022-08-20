<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ReceiptByItemLoyverse;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReceiptByItemLoyversePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the receiptByItemLoyverse can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list receiptbyitemloyverses');
    }

    /**
     * Determine whether the receiptByItemLoyverse can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ReceiptByItemLoyverse  $model
     * @return mixed
     */
    public function view(User $user, ReceiptByItemLoyverse $model)
    {
        return $user->hasPermissionTo('view receiptbyitemloyverses');
    }

    /**
     * Determine whether the receiptByItemLoyverse can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create receiptbyitemloyverses');
    }

    /**
     * Determine whether the receiptByItemLoyverse can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ReceiptByItemLoyverse  $model
     * @return mixed
     */
    public function update(User $user, ReceiptByItemLoyverse $model)
    {
        return $user->hasPermissionTo('update receiptbyitemloyverses');
    }

    /**
     * Determine whether the receiptByItemLoyverse can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ReceiptByItemLoyverse  $model
     * @return mixed
     */
    public function delete(User $user, ReceiptByItemLoyverse $model)
    {
        return $user->hasPermissionTo('delete receiptbyitemloyverses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ReceiptByItemLoyverse  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete receiptbyitemloyverses');
    }

    /**
     * Determine whether the receiptByItemLoyverse can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ReceiptByItemLoyverse  $model
     * @return mixed
     */
    public function restore(User $user, ReceiptByItemLoyverse $model)
    {
        return false;
    }

    /**
     * Determine whether the receiptByItemLoyverse can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ReceiptByItemLoyverse  $model
     * @return mixed
     */
    public function forceDelete(User $user, ReceiptByItemLoyverse $model)
    {
        return false;
    }
}
