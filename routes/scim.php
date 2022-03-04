<?php

use ArieTimmerman\Laravel\SCIMServer\Http\Controllers\ResourceController;
use ArieTimmerman\Laravel\SCIMServer\Http\Controllers\ResourceTypesController;
use ArieTimmerman\Laravel\SCIMServer\Http\Controllers\SchemaController;
use ArieTimmerman\Laravel\SCIMServer\Http\Controllers\ServiceProviderController;
use ArieTimmerman\Laravel\SCIMServer\Middleware\SCIMHeaders;


// first map *PUBLIC* routes
Route::group(['prefix' => 'scim'], function () {
    //v1 (Deprecated SCIM) public routes
    Route::get('v1', '\ArieTimmerman\Laravel\SCIMServer\Http\Controllers\ResourceController@wrongVersion');
    Route::prefix('v1')->group(
        function () {
            Route::fallback('\ArieTimmerman\Laravel\SCIMServer\Http\Controllers\ResourceController@wrongVersion');
        }
    );

    //v2 public routes
    Route::get("v2/ServiceProviderConfig", '\ArieTimmerman\Laravel\SCIMServer\Http\Controllers\ServiceProviderController@index')->name('scim.serviceproviderconfig');
        
    Route::get("v2/Schemas", '\ArieTimmerman\Laravel\SCIMServer\Http\Controllers\SchemaController@index');
    Route::get("v2/Schemas/{id}", '\ArieTimmerman\Laravel\SCIMServer\Http\Controllers\SchemaController@show')->name('scim.schemas');
    
    Route::get("v2/ResourceTypes", '\ArieTimmerman\Laravel\SCIMServer\Http\Controllers\ResourceTypesController@index');
    Route::get("v2/ResourceTypes/{id}", '\ArieTimmerman\Laravel\SCIMServer\Http\Controllers\ResourceTypesController@show')->name('scim.resourcetype');

    //v2 *authenticated* routes - 
    // FIXME && TODO - 
    // Inherently, there is no check against the actual granted permissions on the OAuth token (which seems to actually be working?!)
    // so you could use the shittiest token from the crappiest user and do a SCIM integration with it.
    // SO PLEASE FIXME BEFORE GOING LIVE!!!
    Route::group(['prefix' => 'v2','middleware' => ['api', SCIMHeaders::class]], function () {
        Route::post('.search', '\ArieTimmerman\Laravel\SCIMServer\Http\Controllers\ResourceController@notImplemented');
            
        Route::get('/{resourceType}/{resourceObject}', '\ArieTimmerman\Laravel\SCIMServer\Http\Controllers\ResourceController@show')->name('scim.resource');
        Route::get("/{resourceType}", '\ArieTimmerman\Laravel\SCIMServer\Http\Controllers\ResourceController@index')->name('scim.resources');
        
        Route::post("/{resourceType}", '\ArieTimmerman\Laravel\SCIMServer\Http\Controllers\ResourceController@create');
        
        Route::put("/{resourceType}/{resourceObject}", '\ArieTimmerman\Laravel\SCIMServer\Http\Controllers\ResourceController@replace');
        Route::patch("/{resourceType}/{resourceObject}", '\ArieTimmerman\Laravel\SCIMServer\Http\Controllers\ResourceController@update');
        Route::delete("/{resourceType}/{resourceObject}", '\ArieTimmerman\Laravel\SCIMServer\Http\Controllers\ResourceController@delete');
        
        Route::fallback('\ArieTimmerman\Laravel\SCIMServer\Http\Controllers\ResourceController@notImplemented');
    });

});

// now map AUTHENTICATED routes (using api middleware, which includes throttling)
// Note: Azure might make us crank up the rate-limiting for these SCIM API's :/

