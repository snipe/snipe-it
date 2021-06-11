<?php

use App\Http\Controllers\AssetModelsController;
use App\Http\Controllers\BulkAssetModelsController;
use Illuminate\Support\Facades\Route;

// Asset Model Management
Route::group(['prefix' => 'models', 'middleware' => ['auth']], function () {
    Route::get('{modelId}/clone', ['as' => 'clone/model', 'uses' => [AssetModelsController::class, 'getClone']]);
    Route::post('{modelId}/clone', [AssetModelsController::class, 'postCreate']);
    Route::get('{modelId}/view', ['as' => 'view/model', 'uses' => [AssetModelsController::class, 'getView']]);
    Route::get('{modelID}/restore', ['as' => 'restore/model', 'uses' => [AssetModelsController::class, 'getRestore'], 'middleware' => ['authorize:superuser']]);
    Route::get('{modelId}/custom_fields', ['as' => 'custom_fields/model', 'uses' => [AssetModelsController::class, 'getCustomFields']]);
    Route::post('bulkedit', ['as' => 'models.bulkedit.index', 'uses' => [BulkAssetModelsController::class, 'edit']]);
    Route::post('bulksave', ['as' => 'models.bulkedit.store', 'uses' => [BulkAssetModelsController::class, 'update']]);
    Route::post('bulkdelete', ['as' => 'models.bulkdelete.store', 'uses' => [BulkAssetModelsController::class, 'destroy']]);
});

Route::resource('models', AssetModelsController::class, [
    'middleware' => ['auth'],
    'parameters' => ['model' => 'model_id'],
]);
