<?php

/*
* Accessories
 */
Route::group([ 'prefix' => 'accessories', 'middleware'=>'authorize:accessories.view'  ], function () {


    Route::get(
        '{accessoryID}/checkout',
        [ 'as' => 'checkout/accessory', 'middleware' => 'authorize:accessories.checkout','uses' => 'AccessoriesController@getCheckout' ]
    );
    Route::post(
        '{accessoryID}/checkout',
        [ 'as' => 'checkout/accessory', 'middleware' => 'authorize:accessories.checkout','uses' => 'AccessoriesController@postCheckout' ]
    );

    Route::get(
        '{accessoryID}/checkin/{backto?}',
        [ 'as' => 'checkin/accessory', 'middleware' => 'authorize:accessories.checkin','uses' => 'AccessoriesController@getCheckin' ]
    );
    Route::post(
        '{accessoryID}/checkin/{backto?}',
        [ 'as' => 'checkin/accessory', 'middleware' => 'authorize:accessories.checkin','uses' => 'AccessoriesController@postCheckin' ]
    );

});

Route::resource('accessories', 'AccessoriesController', [
    'parameters' => ['accessory' => 'accessory_id']
]);
