<?php

// Predefined Kit Management
Route::resource('kit', 'Kits\PredefinedKitController', [
    'middleware' => ['auth'],
    'parameters' => ['kit' => 'kit_id']
]);



Route::group([ 'prefix' => 'kits/{kit_id}', 'middleware' => ['auth'] ], function () {

    Route::get('licenses', 
        [
            'as' => 'kits.licenses.index',
            'uses' => 'Kits\PredefinedKitsController@indexLicenses',
        ]
    );
    
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
            'as' => 'kits.licenses.destroy',
            'uses' => 'Kits\PredefinedKitsController@destroyLicense',
        ]
    );
    
    
    Route::get('models', 
        [
            'as' => 'kits.models.index',
            'uses' => 'Kits\PredefinedKitsController@indexModels',
        ]
    );
    
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
        ]
    );

    Route::delete('models/{model_id}', 
        [
            'as' => 'kits.models.destroy',
            'uses' => 'Kits\PredefinedKitsController@destroyModel',
        ]
    );

}); // kits