<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class StatuslabelPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'statuslabels';
    }
}
