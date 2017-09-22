<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LicensePolicy
{
    use HandlesAuthorization;


    public function before(User $user, $ability, $license)
    {
        // Lets move all company related checks here.
        if ($license instanceof \App\Models\License && !Company::isCurrentUserHasAccess($license)) {
            return false;
        }
        // If an admin, they can do all asset related tasks.
        if ($user->hasAccess('admin')) {
            return true;
        }
    }
    /**
     * Determine whether the user can view the license.
     *
     * @param  \App\User  $user
     * @param  \App\License  $license
     * @return mixed
     */
    public function view(User $user, License $license = null)
    {
        //
        return $user->hasAccess('licenses.view');
    }

    /**
     * Determine whether the user can create licenses.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        return $user->hasAccess('licenses.create');
    }

    /**
     * Determine whether the user can update the license.
     *
     * @param  \App\User  $user
     * @param  \App\License  $license
     * @return mixed
     */
    public function update(User $user, License $license = null)
    {
        //
        return $user->hasAccess('licenses.edit');
    }

    /**
     * Determine whether the user can delete the license.
     *
     * @param  \App\User  $user
     * @param  \App\License  $license
     * @return mixed
     */
    public function delete(User $user, License $license = null)
    {
        //
        return $user->hasAccess('licenses.delete');
    }

   /**
     * Determine whether the user can checkout the license.
     *
     * @param  \App\User  $user
     * @param  \App\Accessory  $license
     * @return mixed
     */
    public function checkout(User $user, LicenseSeat $license = null)
    {
        return $user->hasAccess('licenses.checkout');
    }

   /**
     * Determine whether the user can checkin the license.
     *
     * @param  \App\User  $user
     * @param  \App\License  $license
     * @return mixed
     */
    public function checkin(User $user, LicenseSeat $license = null)
    {
        return $user->hasAccess('licenses.checkin');
    }
   /**
     * Determine whether the user can view license keys
     *
     * @param  \App\User  $user
     * @param  \App\License  $license
     * @return mixed
     */
    public function viewKeys(User $user, License $license = null)
    {
        return $user->hasAccess('licenses.keys');
    }

     /**
     * Determine whether the user can manage the license.
     *
     * @param  \App\User  $user
     * @param  \App\License  $license
     * @return mixed
     */
    public function manage(User $user, License $license = null)
    {
        return $user->hasAccess('licenses.checkin')
             || $user->hasAccess('licenses.edit')
             || $user->hasAccess('licenses.delete')
             || $user->hasAccess('licenses.checkout');
    }
}
