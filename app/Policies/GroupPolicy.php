<?php

namespace App\Policies;
use App\Policies\SnipePermissionsPolicy;


/**
* @copyright: Copyright (c) 2021 Elektrobit Automotive GmbH
*/

class GroupPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'group';
    }
}