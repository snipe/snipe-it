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
 *
 */

abstract class SnipePermissionsPolicy
{
    /**
     * This should return the key of the model in the users json permission string.
     *
     * @return boolean
     */

    //
    abstract protected function columnName();

        use HandlesAuthorization;

    public function before(User $user, $ability, $item)
    {
        // Lets move all company related checks here.
        if ($item instanceof \App\Models\SnipeModel && !Company::isCurrentUserHasAccess($item)) {
            return false;
        }
        // If an admin, they can do all asset related tasks.
        if ($user->hasAccess('admin')) {
            return true;
        }
    }

    public function index(User $user)
    {
        return $user->hasAccess($this->columnName().'.view');
    }
    /**
     * Determine whether the user can view the accessory.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user, $item = null)
    {
        return $user->hasAccess($this->columnName().'.view');
    }

    /**
     * Determine whether the user can create accessories.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess($this->columnName().'.create');
    }

    /**
     * Determine whether the user can update the accessory.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user, $item = null)
    {
        return $user->hasAccess($this->columnName().'.edit');
    }

    /**
     * Determine whether the user can delete the accessory.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $user, $item = null)
    {
        return $user->hasAccess($this->columnName().'.delete');
    }

     /**
     * Determine whether the user can manage the accessory.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function manage(User $user, $item = null)
    {
        return $user->hasAccess($this->columnName().'.edit');
    }


}
