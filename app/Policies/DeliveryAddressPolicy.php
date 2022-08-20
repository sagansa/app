<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DeliveryAddress;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryAddressPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the deliveryAddress can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list deliveryaddresses');
    }

    /**
     * Determine whether the deliveryAddress can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DeliveryAddress  $model
     * @return mixed
     */
    public function view(User $user, DeliveryAddress $model)
    {
        return $user->hasPermissionTo('view deliveryaddresses');
    }

    /**
     * Determine whether the deliveryAddress can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create deliveryaddresses');
    }

    /**
     * Determine whether the deliveryAddress can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DeliveryAddress  $model
     * @return mixed
     */
    public function update(User $user, DeliveryAddress $model)
    {
        return $user->hasPermissionTo('update deliveryaddresses');
    }

    /**
     * Determine whether the deliveryAddress can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DeliveryAddress  $model
     * @return mixed
     */
    public function delete(User $user, DeliveryAddress $model)
    {
        return $user->hasPermissionTo('delete deliveryaddresses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DeliveryAddress  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete deliveryaddresses');
    }

    /**
     * Determine whether the deliveryAddress can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DeliveryAddress  $model
     * @return mixed
     */
    public function restore(User $user, DeliveryAddress $model)
    {
        return false;
    }

    /**
     * Determine whether the deliveryAddress can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DeliveryAddress  $model
     * @return mixed
     */
    public function forceDelete(User $user, DeliveryAddress $model)
    {
        return false;
    }
}
