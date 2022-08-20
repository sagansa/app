<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CashlessProvider;
use Illuminate\Auth\Access\HandlesAuthorization;

class CashlessProviderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the cashlessProvider can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list cashlessproviders');
    }

    /**
     * Determine whether the cashlessProvider can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashlessProvider  $model
     * @return mixed
     */
    public function view(User $user, CashlessProvider $model)
    {
        return $user->hasPermissionTo('view cashlessproviders');
    }

    /**
     * Determine whether the cashlessProvider can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create cashlessproviders');
    }

    /**
     * Determine whether the cashlessProvider can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashlessProvider  $model
     * @return mixed
     */
    public function update(User $user, CashlessProvider $model)
    {
        return $user->hasPermissionTo('update cashlessproviders');
    }

    /**
     * Determine whether the cashlessProvider can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashlessProvider  $model
     * @return mixed
     */
    public function delete(User $user, CashlessProvider $model)
    {
        return $user->hasPermissionTo('delete cashlessproviders');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashlessProvider  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete cashlessproviders');
    }

    /**
     * Determine whether the cashlessProvider can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashlessProvider  $model
     * @return mixed
     */
    public function restore(User $user, CashlessProvider $model)
    {
        return false;
    }

    /**
     * Determine whether the cashlessProvider can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CashlessProvider  $model
     * @return mixed
     */
    public function forceDelete(User $user, CashlessProvider $model)
    {
        return false;
    }
}
