<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PurchaseOrderProduct;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchaseOrderProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the purchaseOrderProduct can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list purchaseorderproducts');
    }

    /**
     * Determine whether the purchaseOrderProduct can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseOrderProduct  $model
     * @return mixed
     */
    public function view(User $user, PurchaseOrderProduct $model)
    {
        return $user->hasPermissionTo('view purchaseorderproducts');
    }

    /**
     * Determine whether the purchaseOrderProduct can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create purchaseorderproducts');
    }

    /**
     * Determine whether the purchaseOrderProduct can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseOrderProduct  $model
     * @return mixed
     */
    public function update(User $user, PurchaseOrderProduct $model)
    {
        return $user->hasPermissionTo('update purchaseorderproducts');
    }

    /**
     * Determine whether the purchaseOrderProduct can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseOrderProduct  $model
     * @return mixed
     */
    public function delete(User $user, PurchaseOrderProduct $model)
    {
        return $user->hasPermissionTo('delete purchaseorderproducts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseOrderProduct  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete purchaseorderproducts');
    }

    /**
     * Determine whether the purchaseOrderProduct can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseOrderProduct  $model
     * @return mixed
     */
    public function restore(User $user, PurchaseOrderProduct $model)
    {
        return false;
    }

    /**
     * Determine whether the purchaseOrderProduct can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PurchaseOrderProduct  $model
     * @return mixed
     */
    public function forceDelete(User $user, PurchaseOrderProduct $model)
    {
        return false;
    }
}
