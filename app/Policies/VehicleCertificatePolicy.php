<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VehicleCertificate;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehicleCertificatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the vehicleCertificate can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list vehiclecertificates');
    }

    /**
     * Determine whether the vehicleCertificate can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\VehicleCertificate  $model
     * @return mixed
     */
    public function view(User $user, VehicleCertificate $model)
    {
        return $user->hasPermissionTo('view vehiclecertificates');
    }

    /**
     * Determine whether the vehicleCertificate can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create vehiclecertificates');
    }

    /**
     * Determine whether the vehicleCertificate can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\VehicleCertificate  $model
     * @return mixed
     */
    public function update(User $user, VehicleCertificate $model)
    {
        return $user->hasPermissionTo('update vehiclecertificates');
    }

    /**
     * Determine whether the vehicleCertificate can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\VehicleCertificate  $model
     * @return mixed
     */
    public function delete(User $user, VehicleCertificate $model)
    {
        return $user->hasPermissionTo('delete vehiclecertificates');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\VehicleCertificate  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete vehiclecertificates');
    }

    /**
     * Determine whether the vehicleCertificate can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\VehicleCertificate  $model
     * @return mixed
     */
    public function restore(User $user, VehicleCertificate $model)
    {
        return false;
    }

    /**
     * Determine whether the vehicleCertificate can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\VehicleCertificate  $model
     * @return mixed
     */
    public function forceDelete(User $user, VehicleCertificate $model)
    {
        return false;
    }
}
