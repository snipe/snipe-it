<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class CategoryPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'categories';
    }
}
