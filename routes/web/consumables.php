<?php


    # Consumables
    Route::group([ 'prefix' => 'consumables', 'middleware'=>'authorize:consumables.view'  ], function () {
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
        'parameters' => ['consumable' => 'consumable_id']
    ]);
