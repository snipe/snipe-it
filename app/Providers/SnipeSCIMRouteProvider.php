<?php

namespace App\Providers;
use ArieTimmerman\Laravel\SCIMServer\RouteProvider;

// THIS IS GENERALLY UNUSED - FIXME, DELETE!

// class SnipeSCIMRouteProvider extends RouteProvider
// {
//     // NOTE - this is just an extension of the default RouteProvider that the package comes with
//     public static function routes(array $options = [])
//     {

//         if (!isset($options['public_routes']) || $options['public_routes'] === true) {
//             self::publicRoutes($options);
//         }

//         Route::prefix(self::$prefix)->group(
//             function () use ($options) {
//                 Route::prefix('v2')->middleware(
//                     [
//                     // TODO: Not loading this middleware introduces resolve issues. But having it, might slow things down.
//                     \Illuminate\Routing\Middleware\SubstituteBindings::class,
//                     'ArieTimmerman\Laravel\SCIMServer\Middleware\SCIMHeaders',
//                     'api'
//                     ]
//                 )->group(
//                     function () use ($options) {
//                         self::allRoutes($options);
//                     }
//                 );
            
//                 Route::get('v1', '\ArieTimmerman\Laravel\SCIMServer\Http\Controllers\ResourceController@wrongVersion');
//                 Route::prefix('v1')->group(
//                     function () {
//                         Route::fallback('\ArieTimmerman\Laravel\SCIMServer\Http\Controllers\ResourceController@wrongVersion');
//                     }
//                 );
//             }
//         );
//     }

// }