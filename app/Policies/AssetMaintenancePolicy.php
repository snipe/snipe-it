<?php

namespace App\Policies;
//H.E tout le fichier

class AssetMaintenancePolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'assetmaintenances';
    }
}