<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class CompanyPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'companies';
    }
}
