<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\Location;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
    use HandlesAuthorization;


    public function before(User $user, $location)
    {
        // Lets move all company related checks here.
        if ($location instanceof \App\Models\Location && !Company::isCurrentUserHasAccess($location)) {
            return false;
        }
        // If an admin, they can do all asset related tasks.
        if ($user->hasAccess('admin')) {
            return true;
        }
    }
    /**
     * Determine whether the user can view the location.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Location  $location
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasAccess('locations.view');
    }

    /**
     * Determine whether the user can create locations.
     *
     * @param  \App\Models\\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess('locations.create');
    }

    /**
     * Determine whether the user can update the location.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Location  $location
     * @return mixed
     */
    public function update(User $user)
    {
        //
        return $user->hasAccess('locations.edit');
    }

    /**
     * Determine whether the user can delete the location.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Location  $location
     * @return mixed
     */
    public function delete(User $user)
    {
        //
        return $user->hasAccess('locations.delete');
    }

    /**
     * Determine whether the user can view the location index.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Accessory  $location
     * @return mixed
     */

    public function index(User $user)
    {
        return $user->hasAccess('locations.view');
    }

    /**
     * Determine whether the user can manage the location.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Location  $location
     * @return mixed
     */
    public function manage(User $user)
    {
        return $user->hasAccess('locations.edit');
    }
}
