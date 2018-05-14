<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class AssetModelPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'models';
    }
}
