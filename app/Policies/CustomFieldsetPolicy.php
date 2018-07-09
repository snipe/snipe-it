<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class CustomFieldsetPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'customfieldsets';
    }
}
