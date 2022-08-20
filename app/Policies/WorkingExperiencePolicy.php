<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkingExperience;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkingExperiencePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the workingExperience can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list workingexperiences');
    }

    /**
     * Determine whether the workingExperience can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\WorkingExperience  $model
     * @return mixed
     */
    public function view(User $user, WorkingExperience $model)
    {
        return $user->hasPermissionTo('view workingexperiences');
    }

    /**
     * Determine whether the workingExperience can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create workingexperiences');
    }

    /**
     * Determine whether the workingExperience can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\WorkingExperience  $model
     * @return mixed
     */
    public function update(User $user, WorkingExperience $model)
    {
        return $user->hasPermissionTo('update workingexperiences');
    }

    /**
     * Determine whether the workingExperience can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\WorkingExperience  $model
     * @return mixed
     */
    public function delete(User $user, WorkingExperience $model)
    {
        return $user->hasPermissionTo('delete workingexperiences');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\WorkingExperience  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete workingexperiences');
    }

    /**
     * Determine whether the workingExperience can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\WorkingExperience  $model
     * @return mixed
     */
    public function restore(User $user, WorkingExperience $model)
    {
        return false;
    }

    /**
     * Determine whether the workingExperience can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\WorkingExperience  $model
     * @return mixed
     */
    public function forceDelete(User $user, WorkingExperience $model)
    {
        return false;
    }
}
