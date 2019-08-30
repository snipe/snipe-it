<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class DepreciationPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'depreciations';
    }
}
