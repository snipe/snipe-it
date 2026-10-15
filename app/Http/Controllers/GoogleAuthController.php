<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class GoogleAuthController extends Controller
{
    /**
     * We need this constructor so that we override the socialite expected config variables,
     * since we want to allow this to be changed via database fields
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

    public function handleGoogleCallback(): RedirectResponse
    {
        // Bail before Socialite hits the token endpoint when the callback
        // was reached without a fresh code: user hit Deny, browser back-button
        // replay, bookmarked callback URL, or Google returned an OAuth error.
        // Otherwise Socialite POSTs an empty code and gets a 400 that bubbles
        // as an unhandled ClientException 500.
        if (request()->has('error') || ! request()->has('code')) {
            Log::debug('Google callback hit without a code (error='.request('error', 'none').')');

            return redirect()->route('login')
                ->withErrors(['username' => [trans('auth/general.google_login_failed')]]);
        }

        try {
            $socialUser = Socialite::driver('google')->user();
            Log::debug('Google user found in Google Workspace');
        } catch (InvalidStateException|ClientException $exception) {
            Log::debug('Google callback error: '.$exception->getMessage());

            return redirect()->route('login')
                ->withErrors(['username' => [trans('auth/general.google_login_failed')]]);
        }

        $user = User::where('username', $socialUser->getEmail())
            ->whereNull('deleted_at')
            ->first();

        $user = User::verifyExactUsernameMatch($user, (string) $socialUser->getEmail());

        if ($user) {
            if (! $user->activated) {
                Log::debug('Google user '.$socialUser->getEmail().' is deactivated in Snipe-IT');

                return redirect()->route('login')
                    ->withErrors(['username' => [trans('auth/message.account_not_activated')]]);
            }

            Log::debug('Google user '.$socialUser->getEmail().' found in Snipe-IT');

            $user->avatar = $socialUser->avatar;
            $user->last_login = \Carbon::now();
            $user->save();

            Auth::login($user, true);

            return redirect()->route('home');
        }

        Log::debug('Google user '.$socialUser->getEmail().' NOT found in Snipe-IT');

        return redirect()->route('login')
            ->withErrors(
                [
                    'username' => [
                        trans('auth/general.google_login_failed'),
                    ],
                ]
            );
    }
}
