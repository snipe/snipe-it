<?php

// Predefined Kit Management
Route::resource('kits', 'Kits\PredefinedKitsController', [
    'middleware' => ['auth'],
    'parameters' => ['kit' => 'kit_id']
]);



Route::group([ 'prefix' => 'kits/{kit_id}', 'middleware' => ['auth'] ], function () {

    // Route::get('licenses', 
    //     [
    //         'as' => 'kits.licenses.index',
    //         'uses' => 'Kits\PredefinedKitsController@indexLicenses',
    //     ]
    // );
    
    Route::post('licenses', 
        [
            'as' => 'kits.licenses.store',
            'uses' => 'Kits\PredefinedKitsController@storeLicense',
        ]
    );
    
    Route::put('licenses/{license_id}', 
        [
            'as' => 'kits.licenses.update',
            'uses' => 'Kits\PredefinedKitsController@updateLicense',
        ]
    );
  
    Route::get('licenses/{license_id}/edit', 
        [
            'as' => 'kits.licenses.edit',
            'uses' => 'Kits\PredefinedKitsController@editLicense',
            
        ]
    );

    Route::delete('licenses/{license_id}', 
        [
            'as' => 'kits.licenses.detach',
            'uses' => 'Kits\PredefinedKitsController@detachLicense',
        ]
    );

    
    // Models
    
    Route::put('models/{model_id}', 
        [
            'as' => 'kits.models.update',
            'uses' => 'Kits\PredefinedKitsController@updateModel',
            'parameters' => [2 => 'kit_id', 1 => 'model_id']
        ]
    );
  
    Route::get('models/{model_id}/edit', 
        [
            'as' => 'kits.models.edit',
            'uses' => 'Kits\PredefinedKitsController@editModel',
            
        ]
    );

    Route::delete('models/{model_id}', 
        [
            'as' => 'kits.models.detach',
            'uses' => 'Kits\PredefinedKitsController@detachModel',
        ]
    );


    // Consumables
    Route::put('consumables/{consumable_id}', 
        [
            'as' => 'kits.consumables.update',
            'uses' => 'Kits\PredefinedKitsController@updateConsumable',
            'parameters' => [2 => 'kit_id', 1 => 'consumable_id']
        ]
    );
  
    Route::get('consumables/{consumable_id}/edit', 
        [
            'as' => 'kits.consumables.edit',
            'uses' => 'Kits\PredefinedKitsController@editConsumable',
            
        ]
    );

    Route::delete('consumables/{consumable_id}', 
        [
            'as' => 'kits.consumables.detach',
            'uses' => 'Kits\PredefinedKitsController@detachConsumable',
        ]
    );


    // Accessories
    Route::put('accessories/{accessory_id}', 
        [
            'as' => 'kits.accessories.update',
            'uses' => 'Kits\PredefinedKitsController@updateAccessory',
            'parameters' => [2 => 'kit_id', 1 => 'accessory_id']
        ]
    );

    Route::get('accessories/{accessory_id}/edit', 
        [
            'as' => 'kits.accessories.edit',
            'uses' => 'Kits\PredefinedKitsController@editAccessory',
            
        ]
    );

    Route::delete('accessories/{accessory_id}', 
        [
            'as' => 'kits.accessories.detach',
            'uses' => 'Kits\PredefinedKitsController@detachAccessory',
        ]
    );
    Route::get('checkout',
        [
            'as' => 'kits.checkout.show',
            'uses' => 'Kits\CheckoutKitController@showCheckout',
        ]
    );

    Route::post('checkout',
        [
            'as' => 'kits.checkout.store',
            'uses' => 'Kits\CheckoutKitController@store',
        ]
    );
}); // kits