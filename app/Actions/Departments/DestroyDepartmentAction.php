<?php

namespace App\Actions\Departments;

use App\Exceptions\ItemStillHasUsers;
use App\Models\Department;

class DestroyDepartmentAction
{
    /**
     * @throws ItemStillHasUsers
     */
    public static function run(Department $department): bool
    {
        $department->loadCount(['users as users_count']);

        if ($department->users_count > 0) {
            throw new ItemStillHasUsers($department);
        }

        // Image file cleanup lives on the model's forceDeleted hook so
        // soft-delete + restore preserves the image reference.
        $department->delete();

        return true;
    }
}
