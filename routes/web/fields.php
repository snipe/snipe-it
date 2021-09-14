<?php

use App\Http\Controllers\CustomFieldsController;
use App\Http\Controllers\CustomFieldsetsController;
use Illuminate\Support\Facades\Route;

/*
* Custom Fields Routes
*/

Route::group(['middleware' => ['auth']], function () {

    Route::get(
        'required/{fieldset_id}/{field_id}',
        [
            CustomFieldsetsController::class, 
            'makeFieldRequired'
        ]
    )->name('fields.required');

    Route::get(
        'optional/{fieldset_id}/{field_id}',
        [
            CustomFieldsetsController::class, 
            'makeFieldOptional'
        ]
    )->name('fields.optional');

    Route::get(
        '{field_id}/fieldset/{fieldset_id}/disassociate',
        [
            CustomFieldsetsController::class, 
            'deleteFieldFromFieldset'
        ]
    )->name('fields.disassociate');

    Route::get(
        'fieldsets/{id}/associate',
        [
            CustomFieldsetsController::class, 
            'associate'
        ]
    )->name('fieldsets.associate');

    Route::resource('fieldsets', CustomFieldsetsController::class, [
        'parameters' => ['fieldset' => 'field_id', 'field' => 'field_id'],
        ]);


});
    

Route::resource('fields', CustomFieldsController::class, [
    'parameters' => ['field' => 'field_id'],
]);



