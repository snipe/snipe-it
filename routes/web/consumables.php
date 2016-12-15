<?php


    # Consumables
    Route::group([ 'prefix' => 'consumables', 'middleware'=>'authorize:consumables.view'  ], function () {


        Route::get(
            '{consumableID}/view',
            [ 'as' => 'view/consumable',  'middleware'=>'authorize:consumables.view','uses' => 'ConsumablesController@getView' ]
        );
        Route::get(
            '{consumableID}/checkout',
            [ 'as' => 'checkout/consumable',  'middleware'=>'authorize:consumables.checkout','uses' => 'ConsumablesController@getCheckout' ]
        );
        Route::post(
            '{consumableID}/checkout',
            [ 'as' => 'checkout/consumable',  'middleware'=>'authorize:consumables.checkout','uses' => 'ConsumablesController@postCheckout' ]
        );
    });

    Route::resource('consumables', 'ConsumablesController', [
        'parameters' => ['consumable' => 'consumable_id']
    ]);
