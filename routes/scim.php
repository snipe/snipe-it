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

Route::middleware('auth:api')->group(function () {
    \Log::info("I HAVE LOADED SOME ROUTES!");
    SCIMRouteProvider::routes(
        [
            'public_routes' => false // do not hide public routes (metadata) behind authentication
        ]
    );

    SCIMRouteProvider::meRoutes();
});
\Log::info("Here are PUBLIC routes!!");
SCIMRouteProvider::publicRoutes();


