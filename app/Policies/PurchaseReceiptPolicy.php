<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PurchaseReceipt;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchaseReceiptPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the purchaseReceipt can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list purchasereceipts');
    }

    /**
     * Determine whether the purchaseReceipt can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseReceipt  $model
     * @return mixed
     */
    public function view(User $user, PurchaseReceipt $model)
    {
        return $user->hasPermissionTo('view purchasereceipts');
    }

    /**
     * Determine whether the purchaseReceipt can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create purchasereceipts');
    }

    /**
     * Determine whether the purchaseReceipt can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseReceipt  $model
     * @return mixed
     */
    public function update(User $user, PurchaseReceipt $model)
    {
        return $user->hasPermissionTo('update purchasereceipts');
    }

    /**
     * Determine whether the purchaseReceipt can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseReceipt  $model
     * @return mixed
     */
    public function delete(User $user, PurchaseReceipt $model)
    {
        return $user->hasPermissionTo('delete purchasereceipts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseReceipt  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete purchasereceipts');
    }

    /**
     * Determine whether the purchaseReceipt can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseReceipt  $model
     * @return mixed
     */
    public function restore(User $user, PurchaseReceipt $model)
    {
        return false;
    }

    /**
     * Determine whether the purchaseReceipt can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseReceipt  $model
     * @return mixed
     */
    public function forceDelete(User $user, PurchaseReceipt $model)
    {
        return false;
    }
}
