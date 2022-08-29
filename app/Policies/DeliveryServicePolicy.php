<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DeliveryService;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the deliveryService can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list deliveryservices');
    }

    /**
     * Determine whether the deliveryService can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DeliveryService  $model
     * @return mixed
     */
    public function view(User $user, DeliveryService $model)
    {
        return $user->hasPermissionTo('view deliveryservices');
    }

    /**
     * Determine whether the deliveryService can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create deliveryservices');
    }

    /**
     * Determine whether the deliveryService can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DeliveryService  $model
     * @return mixed
     */
    public function update(User $user, DeliveryService $model)
    {
        return $user->hasPermissionTo('update deliveryservices');
    }

    /**
     * Determine whether the deliveryService can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DeliveryService  $model
     * @return mixed
     */
    public function delete(User $user, DeliveryService $model)
    {
        return $user->hasPermissionTo('delete deliveryservices');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DeliveryService  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete deliveryservices');
    }

    /**
     * Determine whether the deliveryService can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DeliveryService  $model
     * @return mixed
     */
    public function restore(User $user, DeliveryService $model)
    {
        return false;
    }

    /**
     * Determine whether the deliveryService can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DeliveryService  $model
     * @return mixed
     */
    public function forceDelete(User $user, DeliveryService $model)
    {
        return false;
    }
}
