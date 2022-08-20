<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PaymentType;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the paymentType can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list paymenttypes');
    }

    /**
     * Determine whether the paymentType can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PaymentType  $model
     * @return mixed
     */
    public function view(User $user, PaymentType $model)
    {
        return $user->hasPermissionTo('view paymenttypes');
    }

    /**
     * Determine whether the paymentType can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create paymenttypes');
    }

    /**
     * Determine whether the paymentType can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PaymentType  $model
     * @return mixed
     */
    public function update(User $user, PaymentType $model)
    {
        return $user->hasPermissionTo('update paymenttypes');
    }

    /**
     * Determine whether the paymentType can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PaymentType  $model
     * @return mixed
     */
    public function delete(User $user, PaymentType $model)
    {
        return $user->hasPermissionTo('delete paymenttypes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PaymentType  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete paymenttypes');
    }

    /**
     * Determine whether the paymentType can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PaymentType  $model
     * @return mixed
     */
    public function restore(User $user, PaymentType $model)
    {
        return false;
    }

    /**
     * Determine whether the paymentType can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PaymentType  $model
     * @return mixed
     */
    public function forceDelete(User $user, PaymentType $model)
    {
        return false;
    }
}
