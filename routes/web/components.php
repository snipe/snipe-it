<?php

# Components
Route::group([ 'prefix' => 'components','middleware' => ['auth'] ], function () {

    Route::get(
        '{componentID}/checkout',
        [ 'as' => 'checkout/component', 'uses' => 'ComponentsController@getCheckout' ]
    );
    Route::post(
        '{componentID}/checkout',
        [ 'as' => 'checkout/component', 'uses' => 'ComponentsController@postCheckout' ]
    );
    Route::get(
        '{componentID}/checkin',
        [ 'as' => 'checkin/component', 'uses' => 'ComponentsController@getCheckin' ]
    );
    Route::post(
        '{componentID}/checkin',
        [ 'as' => 'component.checkin.save', 'uses' => 'ComponentsController@postCheckin' ]
    );
    Route::post('bulk', [ 'as' => 'component/bulk-form', 'uses' => 'ComponentsController@postBulk' ]);
    Route::post('bulksave', [ 'as' => 'component/bulk-save', 'uses' => 'ComponentsController@postBulkSave' ]);

});

Route::resource('components', 'ComponentsController', [
    'middleware' => ['auth'],
    'parameters' => ['component' => 'component_id']
]);
