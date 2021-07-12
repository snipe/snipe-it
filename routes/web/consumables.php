<?php


    # Consumables
    Route::group([ 'prefix' => 'consumables', 'middleware' => ['auth']], function () {
        Route::get('{consumableID}/checkout', [
            'as' => 'checkout/consumable',
            'uses' => 'Consumables\ConsumableCheckoutController@create' 
        ]);
        Route::post('{consumableID}/checkout', [
             'as' => 'checkout/consumable',
             'uses' => 'Consumables\ConsumableCheckoutController@store'
        ]);
        Route::get('{consumableID}/label', [
            'as' => 'label/consumable',
            'uses' => 'Consumables\ConsumablesController@getLabel'
        ]);
        Route::get('{consumableID}/qr_code', [ 
            'as' => 'qr_code/consumable', 
            'uses' => 'Consumables\ConsumablesController@getQrCode' 
        ]);
        Route::get('{consumableID}/view', [
            'as' => 'consumables.view',
            'uses' => 'Assets\AssetsController@show'
        ]);
        Route::get('{consumableID}/barcode', [ 
            'as' => 'barcode/consumable', 
            'uses' => 'Consumables\ConsumablesController@getBarCode' 
        ]);
        Route::post( 'bulkedit', [
                'as'   => 'consumables/bulkedit',
                'uses' => 'Consumables\BulkConsumablesController@edit'
        ]);
        Route::post('bulkdelete', [
                'as'   => 'consumables/bulkdelete',
                'uses' => 'Consumables\BulkConsumablesController@destroy'
        ]);
        Route::post('bulksave', [
                'as'   => 'consumables/bulksave',
                'uses' => 'Consumables\BulkConsumablesController@update'
        ]);
    });

    Route::resource('consumables', 'Consumables\ConsumablesController', [
        'middleware' => ['auth'],
        'parameters' => ['consumable' => 'consumable_id']
    ]);
