<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class SupplierPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'suppliers';
    }
}
