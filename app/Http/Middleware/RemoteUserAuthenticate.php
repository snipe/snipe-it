<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\User;
use App\Models\LdapAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Auth\Guard;

/**
 * Authenticate a user by using the server global variable.
 *
 * @author Wes Hulette <jwhulette@gmail.com>
 *
 * @since 5.0.0
 * @see https://github.com/Adldap2/Adldap2-Laravel/blob/v4.0/src/Middleware/WindowsAuthenticate.php
 */
class RemoteUserAuthenticate
{
    /**
     * The authenticator implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * The LDAP implementation.
     *
     * @var LdapAd
     */
    protected $ldap;

    /**
     * Returns the configured key to use for retrieving
     * the username from the server global variable.
     *
     * @var string
     */
    const REMOTE_USER_KEY = 'REMOTE_USER';

    /**
     * Returns the configured key to use for retrieving
     * the username from the server global variable.
     * 
     * IIS Sometimes sends this
     *
     * @var string
     */
    const AUTH_USER_KEY = 'AUTH_USER';

    /**
     * Constructor.
     *
     * @param Guard  $auth
     * @param LdapAd $ldap
     */
    public function __construct(Guard $auth, LdapAd $ldap)
    {
        $this->auth = $auth;
        $this->ldap = $ldap;
    }

    /**
     * Handle an incoming request.
     * 
     * @author Wes Hulette <jwhulette@gmail.com>
     * 
     * @since 5.0.0
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return Closure
     */
    public function handle($request, Closure $next)
    {
        if (!$this->auth->check() && $this->ldap->ldapSettings['login_remote_user_enabled']) {
            Log::debug('Authenticatiing via REMOTE_USER.');
            // Retrieve the users account name from the request.
            if ($account = $this->account($request)) {
                // Retrieve the users username from their account name.
                $username = $this->username($account);

                // Finally, retrieve the users authenticatable model and log them in.
                if ($user = $this->retrieveAuthenticatedUser($username)) {
                    $this->auth->login($user, $remember = true);
                }
            }
        }

        return $next($request);
    }

    /**
     * Returns the authenticatable user instance if found.
     * 
     * @author Wes Hulette <jwhulette@gmail.com>
     * 
     * @since 5.0.0
     *
     * @param string $username
     *
     * @return \App\Models\User|null
     */
    protected function retrieveAuthenticatedUser($username): ?User
    {
        try {
            $user = User::where('username', '=', $username)
                ->whereNull('deleted_at')
                ->where('activated', '=', '1')
                ->first();
            Log::debug('Remote user auth lookup complete');
        } catch (Exception $e) {
            Log::error('There was an error authenticating the Remote user: '.$e->getMessage());
        }

        return $user;
    }

    /**
     * Retrieves the users SSO account name from our server.
     * 
     * @author Wes Hulette <jwhulette@gmail.com>
     * 
     * @since 5.0.0
     *
     * @param Request $request
     *
     * @return string|null
     */
    protected function account(Request $request): ?string
    {
        $key = $request->server(self::REMOTE_USER_KEY) ?? $request->server(self::AUTH_USER_KEY);
        return utf8_encode($key);
    }

    /**
     * Retrieves the users username from their full account name.
     * 
     * @author Wes Hulette <jwhulette@gmail.com>
     * 
     * @since 5.0.0
     *
     * @param string $account
     *
     * @return string
     */
    protected function username($account): string
    {
        // Username's may be prefixed with their domain,
        // we just need their account name.
        $username = explode('\\', $account);

        if (2 === count($username)) {
            list($domain, $username) = $username;
        } else {
            $username = $username[key($username)];
        }

        return $username;
    }
}
