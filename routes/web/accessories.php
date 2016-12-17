<?php

/*
* Accessories
 */
Route::group([ 'prefix' => 'accessories', ], function () {

    Route::get(
        '{accessoryID}/checkout',
        [ 'as' => 'checkout/accessory', 'uses' => 'AccessoriesController@getCheckout' ]
    );
    Route::post(
        '{accessoryID}/checkout',
        [ 'as' => 'checkout/accessory', 'uses' => 'AccessoriesController@postCheckout' ]
    );

    Route::get(
        '{accessoryID}/checkin/{backto?}',
        [ 'as' => 'checkin/accessory', 'uses' => 'AccessoriesController@getCheckin' ]
    );
    Route::post(
        '{accessoryID}/checkin/{backto?}',
        [ 'as' => 'checkin/accessory', 'uses' => 'AccessoriesController@postCheckin' ]
    );

});

Route::resource('accessories', 'AccessoriesController', [
    'parameters' => ['accessory' => 'accessory_id']
]);
