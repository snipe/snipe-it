<?php

# Components
Route::group([ 'prefix' => 'components','middleware' => ['auth'] ], function () {

    Route::get(
        '{componentID}/checkout',
        [ 'as' => 'checkout/component', 'uses' => 'Components\ComponentCheckoutController@create' ]
    );
    Route::post(
        '{componentID}/checkout',
        [ 'as' => 'checkout/component', 'uses' => 'Components\ComponentCheckoutController@store' ]
    );
    Route::get(
        '{componentID}/checkin',
        [ 'as' => 'checkin/component', 'uses' => 'Components\ComponentCheckinController@create' ]
    );
    Route::post(
        '{componentID}/checkin',
        [ 'as' => 'component.checkin.save', 'uses' => 'Components\ComponentCheckinController@store' ]
    );

});

Route::resource('components', 'Components\ComponentsController', [
    'middleware' => ['auth'],
    'parameters' => ['component' => 'component_id']
]);
