<?php

# Components
Route::group([ 'prefix' => 'components', 'middleware'=>'authorize:components.view'  ], function () {

    Route::get(
        '{componentID}/checkout',
        [ 'as' => 'checkout/component', 'middleware'=>'authorize:components.checkout','uses' => 'ComponentsController@getCheckout' ]
    );
    Route::post(
        '{componentID}/checkout',
        [ 'as' => 'checkout/component', 'middleware'=>'authorize:components.checkout','uses' => 'ComponentsController@postCheckout' ]
    );
    Route::post('bulk', [ 'as' => 'component/bulk-form', 'middleware'=>'authorize:components.checkout','uses' => 'ComponentsController@postBulk' ]);
    Route::post('bulksave', [ 'as' => 'component/bulk-save', 'middleware'=>'authorize:components.edit','uses' => 'ComponentsController@postBulkSave' ]);

});

Route::resource('components', 'ComponentsController', [
    'parameters' => ['component' => 'component_id']
]);
