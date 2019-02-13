<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\FrameGuard::class,
        \App\Http\Middleware\XssProtectHeader::class,
        \App\Http\Middleware\ReferrerPolicyHeader::class,
        \App\Http\Middleware\ContentSecurityPolicyHeader::class,
        \App\Http\Middleware\NosniffGuard::class,
        \Fideloper\Proxy\TrustProxies::class,
        \App\Http\Middleware\CheckForSetup::class,
        \App\Http\Middleware\CheckForDebug::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\CheckLocale::class,
            \App\Http\Middleware\CheckForTwoFactor::class,
            \Laravel\Passport\Http\Middleware\CreateFreshApiToken::class,
        ],

        'api' => [
            'throttle:60,1',
            'auth:api',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'authorize' => \App\Http\Middleware\CheckPermissions::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];
}
