<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class LocationPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'locations';
    }
}
