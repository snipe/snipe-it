<?php

namespace App\Policies;

use App\Policies\CheckoutablePermissionsPolicy;

class AccessoryPolicy extends CheckoutablePermissionsPolicy
{
    protected function columnName()
    {
        return 'accessories';
    }
}
