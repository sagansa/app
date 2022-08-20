<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CleanAndNeat;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CleanAndNeatPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the cleanAndNeat can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list cleanandneats');
    }

    /**
     * Determine whether the cleanAndNeat can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CleanAndNeat  $model
     * @return mixed
     */
    public function view(User $user, CleanAndNeat $model)
    {
        return $user->hasPermissionTo('view cleanandneats');
    }

    /**
     * Determine whether the cleanAndNeat can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create cleanandneats');
    }

    /**
     * Determine whether the cleanAndNeat can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CleanAndNeat  $model
     * @return mixed
     */
    public function update(User $user, CleanAndNeat $model)
    {
        return $user->hasPermissionTo('update cleanandneats') && $user->id === $model->created_by_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    /**
     * Determine whether the cleanAndNeat can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CleanAndNeat  $model
     * @return mixed
     */
    public function delete(User $user, CleanAndNeat $model)
    {
        return $user->hasPermissionTo('delete cleanandneats');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CleanAndNeat  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete cleanandneats');
    }

    /**
     * Determine whether the cleanAndNeat can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CleanAndNeat  $model
     * @return mixed
     */
    public function restore(User $user, CleanAndNeat $model)
    {
        return false;
    }

    /**
     * Determine whether the cleanAndNeat can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CleanAndNeat  $model
     * @return mixed
     */
    public function forceDelete(User $user, CleanAndNeat $model)
    {
        return false;
    }
}
