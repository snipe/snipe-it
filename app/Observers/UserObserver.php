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
       $changes = $user->getChanges(); 
      unset($changes['updated_at']); 
        //for calling out and logging important changes separately
        foreach ($changes as $key => $value) {
           ray([$key => $value]); 
           if($key == 'permissions') {
               $user->logAdmin(actionType: 'permissions-updated', note: 'user observer', value1: $value); 
           } elseif ($key == 'password') {
               $user->logAdmin(actionType: 'password-updated', note: 'user observer', value1: $value); 
           } elseif ($key == 'last_login') {
               return;
           }
            else {
               $user->logAdmin(actionType: 'user-updated', note: 'user observer', value1: $value); 
           }
        }
        // if ($user->isDirty('password')) {
        //     $user->logAdmin(actionType: 'password-updated', note: 'user observer'); 
        // } elseif ($user->isDirty('last_login')) {
        //    return; 
        // } elseif ($user->isDirty('permissions')) {
        //    $user->logAdmin(actionType: 'permissions-updated', note: 'user observer'); 
        // }
        //  else {
        //     $user->logAdmin(actionType: 'saved', note: 'user observer');  
        // } 
       
    }
}
