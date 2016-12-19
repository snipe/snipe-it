<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\Component;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComponentPolicy
{
    use HandlesAuthorization;


    public function before(User $user, $ability, $component)
    {
        // Lets move all company related checks here.
        if ($component instanceof \App\Models\Component && !Company::isCurrentUserHasAccess($component)) {
            return false;
        }
        // If an admin, they can do all asset related tasks.
        if ($user->hasAccess('admin')) {
            return true;
        }
    }
    /**
     * Determine whether the user can view the component.
     *
     * @param  \App\User  $user
     * @param  \App\Component  $component
     * @return mixed
     */
    public function view(User $user, Component $component = null)
    {
        //
        return $user->hasAccess('components.view');
    }

    /**
     * Determine whether the user can create components.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        return $user->hasAccess('components.create');
    }

    /**
     * Determine whether the user can update the component.
     *
     * @param  \App\User  $user
     * @param  \App\Component  $component
     * @return mixed
     */
    public function update(User $user, Component $component = null)
    {
        //
        return $user->hasAccess('components.edit');
    }

    /**
     * Determine whether the user can delete the component.
     *
     * @param  \App\User  $user
     * @param  \App\Component  $component
     * @return mixed
     */
    public function delete(User $user, Component $component = null)
    {
        //
        return $user->hasAccess('components.delete');
    }

   /**
     * Determine whether the user can checkout the component.
     *
     * @param  \App\User  $user
     * @param  \App\Accessory  $component
     * @return mixed
     */
    public function checkout(User $user, Component $component = null)
    {
        return $user->hasAccess('components.checkout');
    }

   /**
     * Determine whether the user can checkin the component.
     *
     * @param  \App\User  $user
     * @param  \App\Component  $component
     * @return mixed
     */
    public function checkin(User $user, Component $component = null)
    {
        return $user->hasAccess('components.checkin');
    }

     /**
     * Determine whether the user can manage the component.
     *
     * @param  \App\User  $user
     * @param  \App\Component  $component
     * @return mixed
     */
    public function manage(User $user, Component $component = null)
    {
        return $user->hasAccess('components.checkin')
             || $user->hasAccess('components.edit')
             || $user->hasAccess('components.checkout');
    }
}
