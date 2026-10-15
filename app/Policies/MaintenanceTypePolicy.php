<?php

namespace App\Policies;

class MaintenanceTypePolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'maintenances';
    }
}
