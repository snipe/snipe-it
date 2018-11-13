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

    Route::delete('licenses/{license_id}', 
        [
            'as' => 'kits.licenses.detach',
            'uses' => 'Kits\PredefinedKitsController@detachLicense',
        ]
    );
    
    
    // Route::get('models', 
    //     [
    //         'as' => 'kits.models.index',
    //         'uses' => 'Kits\PredefinedKitsController@indexModels',
    //     ]
    // );
    
    Route::post('models', 
        [
            'as' => 'kits.models.store',
            'uses' => 'Kits\PredefinedKitsController@storeModel',
        ]
    );
    
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