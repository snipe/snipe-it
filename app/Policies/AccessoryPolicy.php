<?php

namespace App\Policies;

use App\Models\Accessory;
use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccessoryPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, $accessory)
    {
        // Lets move all company related checks here.
        if ($accessory instanceof \App\Models\Accessory && !Company::isCurrentUserHasAccess($accessory)) {
            return false;
        }
        // If an admin, they can do all asset related tasks.
        if ($user->hasAccess('admin')) {
            return true;
        }
    }

    public function index(User $user)
    {
        // dd('here');
        return $user->hasAccess('accessories.view');
    }
    /**
     * Determine whether the user can view the accessory.
     *
     * @param  \App\User  $user
     * @param  \App\Accessory  $accessory
     * @return mixed
     */
    public function view(User $user, Accessory $accessory = null)
    {
        //
        return $user->hasAccess('accessories.view');
    }

    /**
     * Determine whether the user can create accessories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        return $user->hasAccess('accessories.create');
    }

    /**
     * Determine whether the user can update the accessory.
     *
     * @param  \App\User  $user
     * @param  \App\Accessory  $accessory
     * @return mixed
     */
    public function update(User $user, Accessory $accessory = null)
    {
        //
        return $user->hasAccess('accessories.edit');
    }

    /**
     * Determine whether the user can delete the accessory.
     *
     * @param  \App\User  $user
     * @param  \App\Accessory  $accessory
     * @return mixed
     */
    public function delete(User $user, Accessory $accessory = null)
    {
        //
        return $user->hasAccess('accessories.delete');
    }

   /**
     * Determine whether the user can checkout the accessory.
     *
     * @param  \App\User  $user
     * @param  \App\Accessory  $accessory
     * @return mixed
     */
    public function checkout(User $user, Accessory $accessory = null)
    {
        return $user->hasAccess('accessories.checkout');
    }

   /**
     * Determine whether the user can checkin the accessory.
     *
     * @param  \App\User  $user
     * @param  \App\Accessory  $accessory
     * @return mixed
     */
    public function checkin(User $user, Accessory $accessory = null)
    {
        return $user->hasAccess('accessories.checkin');
    }

     /**
     * Determine whether the user can manage the accessory.
     *
     * @param  \App\User  $user
     * @param  \App\Accessory  $accessory
     * @return mixed
     */
    public function manage(User $user, Accessory $accessory = null)
    {
        return $user->hasAccess('accessories.checkin')
             || $user->hasAccess('accessories.edit')
             || $user->hasAccess('accessories.checkout');
    }
}
