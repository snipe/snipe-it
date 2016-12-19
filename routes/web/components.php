<?php

# Components
Route::group([ 'prefix' => 'components' ], function () {

    Route::get(
        '{componentID}/checkout',
        [ 'as' => 'checkout/component', 'uses' => 'ComponentsController@getCheckout' ]
    );
    Route::post(
        '{componentID}/checkout',
        [ 'as' => 'checkout/component', 'uses' => 'ComponentsController@postCheckout' ]
    );
    Route::post('bulk', [ 'as' => 'component/bulk-form', 'uses' => 'ComponentsController@postBulk' ]);
    Route::post('bulksave', [ 'as' => 'component/bulk-save', 'uses' => 'ComponentsController@postBulkSave' ]);

});

Route::resource('components', 'ComponentsController', [
    'parameters' => ['component' => 'component_id']
]);
