<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class CustomFieldsetPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        /**
         * Authorization for custom fieldsets gets proxied down to custom fields
         * in SnipePermissionsPolicy.
         *
         * See: https://github.com/snipe/snipe-it/pull/5795
         */
        return 'customfields';
    }	
}
