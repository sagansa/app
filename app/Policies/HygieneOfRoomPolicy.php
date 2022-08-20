<?php

namespace App\Policies;

use App\Models\User;
use App\Models\HygieneOfRoom;
use Illuminate\Auth\Access\HandlesAuthorization;

class HygieneOfRoomPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the hygieneOfRoom can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list hygieneofrooms');
    }

    /**
     * Determine whether the hygieneOfRoom can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\HygieneOfRoom  $model
     * @return mixed
     */
    public function view(User $user, HygieneOfRoom $model)
    {
        return $user->hasPermissionTo('view hygieneofrooms');
    }

    /**
     * Determine whether the hygieneOfRoom can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create hygieneofrooms');
    }

    /**
     * Determine whether the hygieneOfRoom can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\HygieneOfRoom  $model
     * @return mixed
     */
    public function update(User $user, HygieneOfRoom $model)
    {
        return $user->hasPermissionTo('update hygieneofrooms');
    }

    /**
     * Determine whether the hygieneOfRoom can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\HygieneOfRoom  $model
     * @return mixed
     */
    public function delete(User $user, HygieneOfRoom $model)
    {
        return $user->hasPermissionTo('delete hygieneofrooms');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\HygieneOfRoom  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete hygieneofrooms');
    }

    /**
     * Determine whether the hygieneOfRoom can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\HygieneOfRoom  $model
     * @return mixed
     */
    public function restore(User $user, HygieneOfRoom $model)
    {
        return false;
    }

    /**
     * Determine whether the hygieneOfRoom can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\HygieneOfRoom  $model
     * @return mixed
     */
    public function forceDelete(User $user, HygieneOfRoom $model)
    {
        return false;
    }
}
