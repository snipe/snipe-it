<?php

use App\Http\Controllers\AssetModelsController;
use App\Http\Controllers\AssetModelsFilesController;
use App\Http\Controllers\BulkAssetModelsController;
use Illuminate\Support\Facades\Route;

// Asset Model Management


Route::group(['prefix' => 'models', 'middleware' => ['auth']], function () {

    Route::post('{model}/upload',
        [AssetModelsFilesController::class, 'store']
    )->name('upload/models')->withTrashed();

    Route::get('{model}/showfile/{fileId}/{download?}',
        [AssetModelsFilesController::class, 'show']
    )->name('show/modelfile')->withTrashed();

    Route::delete('{model}/showfile/{fileId}/delete',
        [AssetModelsFilesController::class, 'destroy']
    )->name('delete/modelfile')->withTrashed();

    Route::get(
        '{model}/clone',
        [
            AssetModelsController::class, 
            'getClone'
        ]
    )->name('models.clone.create')->withTrashed();

    Route::post(
        '{model}/clone',
        [
            AssetModelsController::class, 
            'postCreate'
        ]
    )->name('models.clone.store')->withTrashed();

    Route::get(
        '{modelId}/view',
        [
            AssetModelsController::class, 
            'getView'
        ]
    )->name('view/model');

    Route::post(
        '{modelID}/restore',
        [
            AssetModelsController::class, 
            'getRestore'
        ]
    )->name('models.restore.store');

    Route::get(
        '{modelId}/custom_fields',
        [
            AssetModelsController::class, 
            'getCustomFields'
        ]
    )->name('custom_fields/model');

    Route::post(
        'bulkedit',
        [
            BulkAssetModelsController::class, 
            'edit'
        ]
    )->name('models.bulkedit.index');

    Route::post(
        'bulksave',
        [
            BulkAssetModelsController::class, 
            'update'
        ]
    )->name('models.bulkedit.store');

    Route::post(
        'bulkdelete',
        [
            BulkAssetModelsController::class, 
            'destroy'
        ]
    )->name('models.bulkdelete.store');



});

Route::resource('models', AssetModelsController::class, [
    'middleware' => ['auth'],
])->withTrashed();
