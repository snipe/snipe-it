<?php


    # Consumables
    Route::group([ 'prefix' => 'consumables', 'middleware' => ['auth']], function () {
        Route::get(
            '{consumableID}/checkout',
            [ 'as' => 'checkout/consumable','uses' => 'ConsumablesController@getCheckout' ]
        );
        Route::post(
            '{consumableID}/checkout',
            [ 'as' => 'checkout/consumable', 'uses' => 'ConsumablesController@postCheckout' ]
        );
    });

    Route::resource('consumables', 'ConsumablesController', [
        'middleware' => ['auth'],
        'parameters' => ['consumable' => 'consumable_id']
    ]);
