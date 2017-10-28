<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class UserPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'users';
    }
}
