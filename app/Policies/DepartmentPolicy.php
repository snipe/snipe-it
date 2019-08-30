<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class DepartmentPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'departments';
    }
}
