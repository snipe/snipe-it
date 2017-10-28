<?php

namespace App\Policies;

use App\Policies\CheckoutablePermissionsPolicy;

class ConsumablePolicy extends CheckoutablePermissionsPolicy
{
    protected function columnName()
    {
        return 'consumables';
    }
}
