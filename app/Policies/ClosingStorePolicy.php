<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClosingStore;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClosingStorePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the closingStore can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list closingstores');
    }

    /**
     * Determine whether the closingStore can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ClosingStore  $model
     * @return mixed
     */
    public function view(User $user, ClosingStore $model)
    {
        return $user->hasPermissionTo('view closingstores');
    }

    /**
     * Determine whether the closingStore can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create closingstores');
    }

    /**
     * Determine whether the closingStore can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ClosingStore  $model
     * @return mixed
     */
    public function update(User $user, ClosingStore $model)
    {
        return $user->hasPermissionTo('update closingstores');
    }

    /**
     * Determine whether the closingStore can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ClosingStore  $model
     * @return mixed
     */
    public function delete(User $user, ClosingStore $model)
    {
        return $user->hasPermissionTo('delete closingstores');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ClosingStore  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete closingstores');
    }

    /**
     * Determine whether the closingStore can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ClosingStore  $model
     * @return mixed
     */
    public function restore(User $user, ClosingStore $model)
    {
        return false;
    }

    /**
     * Determine whether the closingStore can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ClosingStore  $model
     * @return mixed
     */
    public function forceDelete(User $user, ClosingStore $model)
    {
        return false;
    }
}
