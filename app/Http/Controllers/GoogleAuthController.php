<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;


class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $socialUser = Socialite::driver('google')->user();
        } catch (InvalidStateException $exception) {

            return redirect()->route('login')
                ->withErrors(
                    [
                        'email' => [
                            __('Google Login failed, please try again.'),
                        ],
                    ]
                );
        }


        $user = User::where('email', $socialUser->getEmail())->first();


        if ($user) {
            $user->update([
                'avatar'   => $socialUser->avatar,
            ]);

            Auth::login($user, true);
            return redirect()->route('setup.done');    
        }
        
        return redirect()->route('login')
                ->withErrors(
                    [
                        'email' => [
                            'User not found.',
                        ],
                    ]
                ); 
    }
}
