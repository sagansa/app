<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Hygiene;
use Illuminate\Auth\Access\HandlesAuthorization;

class HygienePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the hygiene can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list hygienes');
    }

    /**
     * Determine whether the hygiene can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Hygiene  $model
     * @return mixed
     */
    public function view(User $user, Hygiene $model)
    {
        return $user->hasPermissionTo('view hygienes');
    }

    /**
     * Determine whether the hygiene can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create hygienes');
    }

    /**
     * Determine whether the hygiene can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Hygiene  $model
     * @return mixed
     */
    public function update(User $user, Hygiene $model)
    {
        return $user->hasPermissionTo('update hygienes');
    }

    /**
     * Determine whether the hygiene can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Hygiene  $model
     * @return mixed
     */
    public function delete(User $user, Hygiene $model)
    {
        return $user->hasPermissionTo('delete hygienes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Hygiene  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete hygienes');
    }

    /**
     * Determine whether the hygiene can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Hygiene  $model
     * @return mixed
     */
    public function restore(User $user, Hygiene $model)
    {
        return false;
    }

    /**
     * Determine whether the hygiene can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Hygiene  $model
     * @return mixed
     */
    public function forceDelete(User $user, Hygiene $model)
    {
        return false;
    }
}
