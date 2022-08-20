<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ReceiptLoyverse;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReceiptLoyversePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the receiptLoyverse can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list receiptloyverses');
    }

    /**
     * Determine whether the receiptLoyverse can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ReceiptLoyverse  $model
     * @return mixed
     */
    public function view(User $user, ReceiptLoyverse $model)
    {
        return $user->hasPermissionTo('view receiptloyverses');
    }

    /**
     * Determine whether the receiptLoyverse can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create receiptloyverses');
    }

    /**
     * Determine whether the receiptLoyverse can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ReceiptLoyverse  $model
     * @return mixed
     */
    public function update(User $user, ReceiptLoyverse $model)
    {
        return $user->hasPermissionTo('update receiptloyverses');
    }

    /**
     * Determine whether the receiptLoyverse can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ReceiptLoyverse  $model
     * @return mixed
     */
    public function delete(User $user, ReceiptLoyverse $model)
    {
        return $user->hasPermissionTo('delete receiptloyverses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ReceiptLoyverse  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete receiptloyverses');
    }

    /**
     * Determine whether the receiptLoyverse can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ReceiptLoyverse  $model
     * @return mixed
     */
    public function restore(User $user, ReceiptLoyverse $model)
    {
        return false;
    }

    /**
     * Determine whether the receiptLoyverse can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ReceiptLoyverse  $model
     * @return mixed
     */
    public function forceDelete(User $user, ReceiptLoyverse $model)
    {
        return false;
    }
}
