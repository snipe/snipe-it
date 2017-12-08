<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class ManufacturerPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'manufacturers';
    }
}
