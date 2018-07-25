<?php

/*
* Accessories
 */
Route::group([ 'prefix' => 'accessories', 'middleware' => ['auth']], function () {

    Route::get(
        '{accessoryID}/checkout',
        [ 'as' => 'checkout/accessory', 'uses' => 'Accessories\AccessoryCheckoutController@create' ]
    );
    Route::post(
        '{accessoryID}/checkout',
        [ 'as' => 'checkout/accessory', 'uses' => 'Accessories\AccessoryCheckoutController@store' ]
    );

    Route::get(
        '{accessoryID}/checkin/{backto?}',
        [ 'as' => 'checkin/accessory', 'uses' => 'Accessories\AccessoryCheckinController@create' ]
    );
    Route::post(
        '{accessoryID}/checkin/{backto?}',
        [ 'as' => 'checkin/accessory', 'uses' => 'Accessories\AccessoryCheckinController@store' ]
    );

});

Route::resource('accessories', 'Accessories\AccessoriesController', [
    'middleware' => ['auth'],
    'parameters' => ['accessory' => 'accessory_id']
]);
