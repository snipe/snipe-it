<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class CustomFieldPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'customfields';
    }
}
