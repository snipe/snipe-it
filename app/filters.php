<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function ($request) {
    //
});


App::after(function ($request, $response) {
    //
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function () {
    // Check if the user is logged in
    if ( ! Sentry::check()) {
        Log::debug('Not logged in - auth filter');
        // Store the current uri in the session
        Session::put('loginRedirect', Request::url());

        // Redirect to the login page
        return Redirect::route('signin');
    }
});


Route::filter('auth.basic', function () {
    return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function () {
    if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| Admin authentication filter.
|--------------------------------------------------------------------------
|
| This filter does the same as the 'auth' filter but it checks if the user
| has 'admin' privileges.
|
*/

Route::filter('admin-auth', function () {
     // Check if the user is logged in
    if ( !Sentry::check()) {
       LOG::debug('Not logged in - admin-auth');
        // Store the current uri in the session
        Session::put('loginRedirect', Request::url());

        // Redirect to the login page
        return Redirect::route('signin');
    }

    // Check if the user has access to the admin pages
    if ( ! Sentry::getUser()->hasAccess('admin')) {
       LOG::debug('Not a super admin');
        // Show the insufficient permissions page
        return Redirect::route('view-assets')->with('error','You do not have permission to view this page.');
    }
});

/*
|--------------------------------------------------------------------------
| Reporting authentication filter.
|--------------------------------------------------------------------------
|
| This filter does the same as the 'auth' filter but it checks if the user
| has 'reports' privileges.
|
*/

Route::filter('reporting-auth', function () {
     // Check if the user is logged in
    if ( ! Sentry::check()) {
       LOG::debug('Not logged in');
        // Store the current uri in the session
        Session::put('loginRedirect', Request::url());

        // Redirect to the login page
        return Redirect::route('signin');
    }

    // Check if the user has access to the admin pages
    if ( ! Sentry::getUser()->hasAccess('reports')) {
        LOG::debug('Unsufficient permissions');
        // Show the insufficient permissions page
        return Redirect::route('profile')->with("error","You do not have permission to view this page.");
    }
});

Route::filter('backup-auth', function () {

    if (!Sentry::getUser()->isSuperUser()) {
        LOG::debug('Not a super admin');
        return Redirect::route('home')->with('error', Lang::get('general.insufficient_permissions'));
    }
});



/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function () {
    if (Session::token() != Input::get('_token')) {
        LOG::debug('No CSRF token');
        throw new Illuminate\Session\TokenMismatchException;
    }
});
