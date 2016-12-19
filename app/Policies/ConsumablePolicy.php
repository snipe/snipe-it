<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\Consumable;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConsumablePolicy
{
    use HandlesAuthorization;


    public function before(User $user, $ability, $consumable)
    {
        // Lets move all company related checks here.
        if ($consumable instanceof \App\Models\Consumable && !Company::isCurrentUserHasAccess($consumable)) {
            return false;
        }
        // If an admin, they can do all asset related tasks.
        if ($user->hasAccess('admin')) {
            return true;
        }
    }
    /**
     * Determine whether the user can view the consumable.
     *
     * @param  \App\User  $user
     * @param  \App\Consumable  $consumable
     * @return mixed
     */
    public function view(User $user, Consumable $consumable = null)
    {
        //
        return $user->hasAccess('consumables.view');
    }

    /**
     * Determine whether the user can create consumables.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        return $user->hasAccess('consumables.create');
    }

    /**
     * Determine whether the user can update the consumable.
     *
     * @param  \App\User  $user
     * @param  \App\Consumable  $consumable
     * @return mixed
     */
    public function update(User $user, Consumable $consumable = null)
    {
        //
        return $user->hasAccess('consumables.edit');
    }

    /**
     * Determine whether the user can delete the consumable.
     *
     * @param  \App\User  $user
     * @param  \App\Consumable  $consumable
     * @return mixed
     */
    public function delete(User $user, Consumable $consumable = null)
    {
        //
        return $user->hasAccess('consumables.delete');
    }

   /**
     * Determine whether the user can checkout the consumable.
     *
     * @param  \App\User  $user
     * @param  \App\Accessory  $consumable
     * @return mixed
     */
    public function checkout(User $user, Consumable $consumable = null)
    {
        return $user->hasAccess('consumables.checkout');
    }

   /**
     * Determine whether the user can checkin the consumable.
     *
     * @param  \App\User  $user
     * @param  \App\Consumable  $consumable
     * @return mixed
     */
    public function checkin(User $user, Consumable $consumable = null)
    {
        return $user->hasAccess('consumables.checkin');
    }

    public function index(User $user)
    {
        return $user->hasAccess('consumables.view');
    }

     /**
     * Determine whether the user can manage the consumable.
     *
     * @param  \App\User  $user
     * @param  \App\Consumable  $consumable
     * @return mixed
     */
    public function manage(User $user, Consumable $consumable = null)
    {
        return $user->hasAccess('consumables.checkin')
             || $user->hasAccess('consumables.edit')
             || $user->hasAccess('consumables.checkout');
    }
}
