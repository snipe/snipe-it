<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
// use App\Services\SnipeLog\SnipeLogFacade as SnipeLog;
use SnipeLog;


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
    $asset = 0;
    $example = 0; 
    // SnipeLog::admin('user-saved'); 
   
    // SnipeLog::admin()->item($user)->actionType('user-saved')->user(Auth::user());
   
    SnipeLog::admin('user-saved')->item($user)->actor(Auth::user());

    // SnipeLog::admin('user-updated')->user(Auth::user())->target($user)->note('user observer');

    // SnipeLog::action('asset-created')->user(Auth::user())->target($asset)->otherOptions($example);
    
    




        // $changes = $user->getChanges(); 
        // unset($changes['updated_at']); 
        // //for calling out and logging important changes separately
        // foreach ($changes as $key => $value) {
        //    $oldValue = $user->getRawOriginal($key); 
        //    if($key == 'permissions') {
        //        $user->logAdmin(actionType: 'permissions-updated', note: 'user observer', providedValue: ['new' => [$key => $value], 'old' => [$key => $oldValue]]); 
        //    } elseif ($key == 'password') {
        //        $user->logAdmin(actionType: 'password-updated', note: 'user observer', providedValue: ['new' => '********', 'old' => '********']); 
        //    } elseif ($key == 'last_login') {
        //        return;
        //    }
        //     else {
        //        $user->logAdmin(actionType: 'user-updated', note: 'user observer', providedValue: ['new' => [$key => $value], 'old' => [$key => $oldValue]]); 
        //    }
        // }




        // if we want to log all changes in one log entry 
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
