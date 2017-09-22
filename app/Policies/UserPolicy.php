<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;


    public function before(User $user, $ability, $targetUser)
    {
        // Lets move all company related checks here.
        if ($targetUser instanceof \App\Models\User && !Company::isCurrentUserHasAccess($targetUser)) {
            return false;
        }
        // If an admin, they can do all user related tasks.
        if ($user->hasAccess('admin')) {
            return true;
        }
    }
    /**
     * Determine whether the user can view the targetUser.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Consumable  $targetUser
     * @return mixed
     */
    public function view(User $user, User $targetUser = null)
    {
        //
        return $user->hasAccess('users.view');
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess('users.create');
    }

    /**
     * Determine whether the user can update the targetUser.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $targetUser
     * @return mixed
     */
    public function update(User $user, User $targetUser = null)
    {
        return $user->hasAccess('users.edit');
    }

    /**
     * Determine whether the user can delete the targetUser.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $targetUser
     * @return mixed
     */
    public function delete(User $user, User $targetUser = null)
    {
        if ($targetUser) {
            //We can't delete ourselves.
            if ($user->id == $targetUser->id) {
                return false;
            }

            if ((!Auth::user()->isSuperUser()) || (config('app.lock_passwords'))) {
                return false;
            }
        }
        return $user->hasAccess('users.delete');
    }

    public function index(User $user)
    {
        return $user->hasAccess('users.view');
    }
}
