<?php

use ArieTimmerman\Laravel\SCIMServer\RouteProvider as SCIMRouteProvider;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| SCIM Routes
|--------------------------------------------------------------------------
|
| These are the routes that we have to explicitly inject from the 
| laravel-scim-server project, which gives Snipe-IT SCIM support
|
*/

SCIMRouteProvider::publicRoutes(); // Make sure to load public routes *FIRST*

Route::middleware('auth:api')->group(function () {
    SCIMRouteProvider::routes(
        [
            'public_routes' => false // do not hide public routes (metadata) behind authentication
        ]
    );

    SCIMRouteProvider::meRoutes();
});
