<?php
/*
* Custom Fields Routes
*/



Route::group([ 'prefix' => 'fields' ], function () {

    Route::get('{field_id}/fieldset/{fieldset_id}/disassociate',
        ['uses' => 'CustomFieldsController@deleteFieldFromFieldset',
        'as' => 'fields.disassociate']
    );

    Route::post('fieldsets/{id}/associate',
        ['uses' => 'CustomFieldsetsController@associate',
        'as' => 'fieldsets.associate']
    );

    Route::resource('fieldsets', 'CustomFieldsetsController', [
    'parameters' => ['fieldset' => 'field_id', 'field' => 'field_id']
    ]);
});

Route::resource('fields', 'CustomFieldsController', [
    'parameters' => ['field' => 'field_id', 'fieldset' => 'fieldset_id']
]);
