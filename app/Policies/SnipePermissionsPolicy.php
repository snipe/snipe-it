<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * SnipePermissionsPolicy provides methods for handling the granular permissions used throughout Snipe-IT.
 * Each "area" of a permission (which is usually a model, like Assets, Departments, etc), has a setting
 * in config/permissions.php like view/create/edit/delete (and sometimes some extra stuff like
 * checkout/checkin, etc.)
 *
 * A Policy should exist for each of these models, however if they only use the standard view/create/edit/delete,
 * the policy can be pretty simple, for example with just one method setting the column name:
 *
 * protected function columnName()
 * {
 *    return 'manufacturers';
 * }
 */
abstract class SnipePermissionsPolicy
{
    /**
     * This should return the key of the model in the users json permission string.
     *
     * @return bool
     */

    //
    abstract protected function columnName();

    use HandlesAuthorization;

    public function before(User $user, $ability, $item)
    {
        // Lets move all company related checks here.
        if ($item instanceof \App\Models\SnipeModel && ! Company::isCurrentUserHasAccess($item)) { // Question: what if $item is a _class_, not an actual object? Isn't that possible? e.g. for @can('create',Statuslabel::class)
            return false;
        }
        \Log::debug("okay, we're still in the before() method, but the \$item is *not* an instance of SnipeModel. User: ".$user->username." Ability: $ability, Item's class is: ".gettype($item));
        // If an admin, they can do all asset related tasks.
        if ($user->hasAccess('admin')) { //*THIS* I kinda think is the thing I'm looking for?
            \Log::info("Yes, we have Admin. Is full company support enabled? ".(Company::isFullMultipleCompanySupportEnabled() ? " yes ": " no ")." what is the item? ".print_r($item,true)." ");
            // if(gettype($item) == "string") { //means that $item is a Class Name.
            //     $real_item = new $item();
            // } elseif(gettype($item) == "object") { //otherwise, we're dealing directly with an instance.
            //     $real_item = $item;
            // } else {
            //     \Log::error("WEIRD TYPE BEING CHECKED FOR!!!");
            //     dd("We're totally toast.");
            // }
            \Log::debug("Is multi-company enabled? ".Company::isFullMultipleCompanySupportEnabled()." does the company method exists? ". method_exists($item, 'company')." and is this a wird \$ability? :$ability");

            if (Company::isFullMultipleCompanySupportEnabled() && !method_exists($item, 'company') && !in_array($ability, ['view', 'index', 'viewRequestable'] )) {
                //I suspect that is_null($item->company_id) will *ALWAYS* be true, because we probably caught any SnipeModel things (which have $company_id) above.
                // \Log::info("This looks like you're going to try and do a create, update, or delete on something that *doesn't* have a company_id. So I think you are boned. False for you.");
                \Log::info("then you're boned, this is something that isn't 'companied' so you can't make 'em.");
                return false; //Admin users *CANNOT* make any changes to cross-company things.
            }
            \Log::info("you're good, go ahead then.");
            return true;
        }
    }

    public function index(User $user)
    {
        return $user->hasAccess($this->columnName().'.view');
    }

    /**
     * Determine whether the user can view the $item.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user, $item = null)
    {
        return $user->hasAccess($this->columnName().'.view');
    }

    /**
     * Determine whether the user can create $items.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess($this->columnName().'.create');
    }

    /**
     * Determine whether the user can update the $item.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user, $item = null)
    {
        return $user->hasAccess($this->columnName().'.edit');
    }

    /**
     * Determine whether the user can delete the $item.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $user, $item = null)
    {
        $itemConditional = true;
        if ($item) {
            $itemConditional = empty($item->deleted_at);
        }

        return $itemConditional && $user->hasAccess($this->columnName().'.delete');
    }

    /**
     * Determine whether the user can manage the $item.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function manage(User $user, $item = null)
    {
        return $user->hasAccess($this->columnName().'.edit');
    }
}
