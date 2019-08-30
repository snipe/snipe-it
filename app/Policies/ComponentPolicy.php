<?php

namespace App\Policies;

use App\Policies\CheckoutablePermissionsPolicy;

class ComponentPolicy extends CheckoutablePermissionsPolicy
{
    protected function columnName()
    {
        return 'components';
    }
}
