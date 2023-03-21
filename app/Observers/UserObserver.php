<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "saved" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function saved(User $user)
    {
        if ($user->isDirty('password')) {
            $user->logAdmin(actionType: 'password-updated', note: 'user observer'); 
        } else {
            $user->logAdmin(actionType: 'saved', note: 'user observer');  
        } 
       
    }
}
