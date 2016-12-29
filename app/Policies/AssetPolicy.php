<?php

namespace App\Policies;

use App\Models\Asset;
use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssetPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before(User $user, $ability, $asset)
    {
        // Lets move all company related checks here.
        if ($asset instanceof \App\Models\Asset && !Company::isCurrentUserHasAccess($asset)) {
            return false;
        }
        // If an admin, they can do all asset related tasks.
        if ($user->hasAccess('admin')) {
            return true;
        }
    }
    public function index(User $user)
    {
        return $user->hasAccess('assets.view');
    }
    public function view(User $user, Asset $asset)
    {
        return $user->hasAccess('assets.view');
    }

    public function viewRequestable(User $user, Asset $asset = null)
    {
        return $user->hasAccess('assets.view.requestable');
    }

    public function create(User $user)
    {
        return $user->hasAccess('assets.create');
    }

    public function checkout(User $user, Asset $asset = null)
    {
        return $user->hasAccess('assets.checkout');
    }

    public function checkin(User $user, Asset $asset = null)
    {
        return $user->hasAccess('assets.checkin');
    }

    public function delete(User $user, Asset $asset = null)
    {
        return $user->hasAccess('assets.delete');
    }
    public function manage(User $user, Asset $asset = null)
    {
        return $user->hasAccess('assets.checkin')
                || $user->hasAccess('assets.edit')
                || $user->hasAccess('assets.delete')
                || $user->hasAccess('assets.checkout');
    }

    public function update(User $user, Asset $asset = null)
    {
        return $user->hasAccess('assets.edit');
    }
}
