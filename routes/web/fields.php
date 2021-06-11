<?php

use App\Http\Controllers\CustomFieldsController;
use App\Http\Controllers\CustomFieldsetsController;
use Illuminate\Support\Facades\Route;
/*
* Custom Fields Routes
*/

Route::group(['prefix' => 'fields', 'middleware' => ['auth']], function () {
    Route::get('required/{fieldset_id}/{field_id}',
        ['uses' => [CustomFieldsetsController::class, 'makeFieldRequired'],
            'as' => 'fields.required', ]
    );

    Route::get('optional/{fieldset_id}/{field_id}',
        ['uses' => [CustomFieldsetsController::class, 'makeFieldOptional'],
            'as' => 'fields.optional', ]
    );

    Route::get('{field_id}/fieldset/{fieldset_id}/disassociate',
        ['uses' => [CustomFieldsController::class, 'deleteFieldFromFieldset'],
        'as' => 'fields.disassociate', ]
    );

    Route::post('fieldsets/{id}/associate',
        ['uses' => [CustomFieldsetsController::class, 'associate'],
        'as' => 'fieldsets.associate', ]
    );

    Route::resource('fieldsets', CustomFieldsetsController::class, [
    'parameters' => ['fieldset' => 'field_id', 'field' => 'field_id'],
    ]);
});

Route::resource('fields', CustomFieldsController::class, [
    'middleware' => ['auth'],
    'parameters' => ['field' => 'field_id', 'fieldset' => 'fieldset_id'],
]);
