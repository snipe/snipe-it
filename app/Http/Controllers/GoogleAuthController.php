<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use App\Models\Setting;


class GoogleAuthController extends Controller
{
    /**
     * We need this constructor so that we override the socialite expected config variables
     */
    public function __construct()
    {
        parent::__construct();
        $setting = Setting::getSettings();
        config(['services.google.redirect' => config('app.url').'/google/callback']);
        config(['services.google.client_id' => $setting->google_client_id]);
        config(['services.google.client_secret' => $setting->google_client_secret]);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $socialUser = Socialite::driver('google')->user();
            \Log::debug('Google user found');
        } catch (InvalidStateException $exception) {
            \Log::debug('Google user NOT found');
            return redirect()->route('login')
                ->withErrors(
                    [
                        'username' => [
                           trans('auth/general.google_login_failed')
                        ],
                    ]
                );
        }


        $user = User::where('username', $socialUser->getEmail())->first();


        if ($user) {
            
            Auth::login($user, true);
            return redirect()->route('home');
        }

        return redirect()->route('login')
            ->withErrors(
                [
                    'email' => [
                        trans('admin/users/message.user_not_found'),
                    ],
                ]
            );
    }
}