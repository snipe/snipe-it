<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;


    public function before(User $user, $category)
    {
        // Lets move all company related checks here.
        if ($category instanceof \App\Models\Category && !Company::isCurrentUserHasAccess($category)) {
            return false;
        }
        // If an admin, they can do all asset related tasks.
        if ($user->hasAccess('admin')) {
            return true;
        }
    }
    /**
     * Determine whether the user can view the category.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Category  $category
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasAccess('categories.view');
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess('categories.create');
    }

    /**
     * Determine whether the user can update the category.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Category  $category
     * @return mixed
     */
    public function update(User $user)
    {
        //
        return $user->hasAccess('categories.edit');
    }

    /**
     * Determine whether the user can delete the category.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Category  $category
     * @return mixed
     */
    public function delete(User $user)
    {
        //
        return $user->hasAccess('categories.delete');
    }

    /**
     * Determine whether the user can view the category index.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return mixed
     */

    public function index(User $user)
    {
        return $user->hasAccess('categories.view');
    }

    /**
     * Determine whether the user can manage the category.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Category  $category
     * @return mixed
     */
    public function manage(User $user)
    {
        return  $user->hasAccess('categories.edit');
    }
}
