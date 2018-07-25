<?php

# Asset Model Management
Route::group([ 'prefix' => 'models', 'middleware' => ['auth'] ], function () {

    Route::get('{modelId}/clone', [ 'as' => 'clone/model', 'uses' => 'AssetModelsController@getClone' ]);
    Route::post('{modelId}/clone', 'AssetModelsController@postCreate');
    Route::get('{modelId}/view', [ 'as' => 'view/model', 'uses' => 'AssetModelsController@getView' ]);
    Route::get('{modelID}/restore', [ 'as' => 'restore/model', 'uses' => 'AssetModelsController@getRestore', 'middleware' => ['authorize:superuser'] ]);
    Route::get('{modelId}/custom_fields', ['as' => 'custom_fields/model','uses' => 'AssetModelsController@getCustomFields']);
    Route::post('bulkedit', ['as' => 'models.bulkedit.index','uses' => 'BulkAssetModelsController@edit']);
    Route::post('bulksave', ['as' => 'models.bulkedit.store','uses' => 'BulkAssetModelsController@update']);
    Route::post('bulkdelete', ['as' => 'models.bulkdelete.store','uses' => 'BulkAssetModelsController@destroy']);
});

Route::resource('models', 'AssetModelsController', [
    'middleware' => ['auth'],
    'parameters' => ['model' => 'model_id']
]);
