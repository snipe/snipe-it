<?php

namespace App\Policies;

use App\Models\License;
use App\Models\User;
use App\Policies\CheckoutablePermissionsPolicy;

class LicensePolicy extends CheckoutablePermissionsPolicy
{
    protected function columnName()
    {
        return 'licenses';
    }

   /**
     * Determine whether the user can view license keys
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\License  $license
     * @return mixed
     */
    public function viewKeys(User $user, License $license = null)
    {
        return $user->hasAccess('licenses.keys');
    }

}
