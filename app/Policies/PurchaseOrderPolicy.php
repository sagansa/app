<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PurchaseOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchaseOrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the purchaseOrder can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list purchaseorders');
    }

    /**
     * Determine whether the purchaseOrder can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseOrder  $model
     * @return mixed
     */
    public function view(User $user, PurchaseOrder $model)
    {
        return $user->hasPermissionTo('view purchaseorders');
    }

    /**
     * Determine whether the purchaseOrder can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create purchaseorders');
    }

    /**
     * Determine whether the purchaseOrder can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseOrder  $model
     * @return mixed
     */
    public function update(User $user, PurchaseOrder $model)
    {
        return $user->hasPermissionTo('update purchaseorders');
    }

    /**
     * Determine whether the purchaseOrder can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseOrder  $model
     * @return mixed
     */
    public function delete(User $user, PurchaseOrder $model)
    {
        return $user->hasPermissionTo('delete purchaseorders');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseOrder  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete purchaseorders');
    }

    /**
     * Determine whether the purchaseOrder can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseOrder  $model
     * @return mixed
     */
    public function restore(User $user, PurchaseOrder $model)
    {
        return false;
    }

    /**
     * Determine whether the purchaseOrder can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseOrder  $model
     * @return mixed
     */
    public function forceDelete(User $user, PurchaseOrder $model)
    {
        return false;
    }
}
