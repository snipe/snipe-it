<?php
/*
|--------------------------------------------------------------------------
| Asset Routes
|--------------------------------------------------------------------------
|
| Register all the asset routes.
|
*/
Route::group(
    ['prefix' => 'hardware',
    'middleware' => ['web','auth']],
    function () {

        # Asset Maintenances
        Route::resource('maintenance', 'AssetMaintenancesController', [
            'parameters' => ['assetmaintenance' => 'maintenance_id', 'asset' => 'asset_id']
        ]);


        Route::get('history', [
            'as' => 'asset.import-history',
            'middleware' => 'authorize:assets.checkout',
            'uses' => 'AssetsController@getImportHistory'
        ]);

        Route::post('history', [
            'as' => 'asset.process-import-history',
            'uses' => 'AssetsController@postImportHistory'
        ]);

        Route::get('/bytag', [
            'as'   => 'findbytag/hardware',
            'middleware' => 'authorize:assets.view',
            'uses' => 'AssetsController@getAssetByTag'
        ]);

        Route::get('{assetId}/clone', [
            'as' => 'clone/hardware',
            'middleware' => 'authorize:assets.create',
            'uses' => 'AssetsController@getClone'
        ]);

        Route::post('{assetId}/clone', 'AssetsController@postCreate');
        Route::get('{assetId}/delete', [
            'as' => 'delete/hardware',
            'middleware' => 'authorize:assets.delete',
            'uses' => 'AssetsController@getDelete'
        ]);
        Route::get('{assetId}/checkout', [
            'as' => 'checkout/hardware',
            'middleware' => 'authorize:assets.checkout',
            'uses' => 'AssetsController@getCheckout'
        ]);
        Route::post('{assetId}/checkout', [
            'as' => 'checkout/hardware',
            'middleware' => 'authorize:assets.checkout',
            'uses' => 'AssetsController@postCheckout'
        ]);
        Route::get('{assetId}/checkin/{backto?}', [
            'as' => 'checkin/hardware',
            'middleware' => 'authorize:assets.checkin',
            'uses' => 'AssetsController@getCheckin'
        ]);

        Route::post('{assetId}/checkin/{backto?}', [
            'as' => 'checkin/hardware',
            'middleware' => 'authorize:assets.checkin',
            'uses' => 'AssetsController@postCheckin'
        ]);
        Route::get('{assetId}/view', [
            'as' => 'hardware.view',
            'middleware' => ['authorize:assets.view'],
            'uses' => 'AssetsController@show'
        ]);
        Route::get('{assetId}/qr_code', [ 'as' => 'qr_code/hardware', 'uses' => 'AssetsController@getQrCode' ]);
        Route::get('{assetId}/barcode', [ 'as' => 'barcode/hardware', 'uses' => 'AssetsController@getBarCode' ]);
        Route::get('{assetId}/restore', [
            'as' => 'restore/hardware',
            'middleware' => 'authorize:assets.delete',
            'uses' => 'AssetsController@getRestore'
        ]);
        Route::post('{assetId}/upload', [
            'as' => 'upload/asset',
            'middleware' => 'authorize:assets.edit',
            'uses' => 'AssetsController@postUpload'
        ]);

        Route::get('{assetId}/deletefile/{fileId}', [
            'as' => 'delete/assetfile',
            'middleware' => 'authorize:assets.edit',
            'uses' => 'AssetsController@getDeleteFile'
        ]);

        Route::get('{assetId}/showfile/{fileId}', [
            'as' => 'show/assetfile',
            'middleware' => 'authorize:assets.view',
            'uses' => 'AssetsController@displayFile'
        ]);

        Route::get('import/delete-import/{filename}',  [
                'as' => 'assets/import/delete-file',
                'middleware' => 'authorize:assets.create',
                'uses' => 'AssetsController@getDeleteImportFile'
        ]);

        Route::post( 'import/process/', [ 'as' => 'assets/import/process-file',
                'middleware' => 'authorize:assets.create',
                'uses' => 'AssetsController@postProcessImportFile'
        ]);
        Route::get( 'import/delete/{filename}', [ 'as' => 'assets/import/delete-file',
                'middleware' => 'authorize:assets.create', // TODO What permissions should this require?
                'uses' => 'AssetsController@getDeleteImportFile'
        ]);

        Route::get('import',[
                'as' => 'assets/import',
                'middleware' => 'authorize:assets.create',
                'uses' => 'AssetsController@getImportUpload'
        ]);

        Route::post(
            'bulkedit',
            [
                'as'   => 'hardware/bulkedit',
                'middleware' => 'authorize:assets.edit',
                'uses' => 'AssetsController@postBulkEdit'
            ]
        );
        Route::post(
            'bulkdelete',
            [
                'as'   => 'hardware/bulkdelete',
                'middleware' => 'authorize:assets.delete',
                'uses' => 'AssetsController@postBulkDelete'
            ]
        );
        Route::post(
            'bulksave',
            [
                'as'   => 'hardware/bulksave',
                'middleware' => 'authorize:assets.edit',
                'uses' => 'AssetsController@postBulkSave'
            ]
        );

        # Bulk checkout / checkin
         Route::get( 'bulkcheckout',  [
                 'as' => 'hardware/bulkcheckout',
                 'middleware' => 'authorize:assets.checkout',
                 'uses' => 'AssetsController@getBulkCheckout'
         ]);
        Route::post( 'bulkcheckout',  [
            'as' => 'hardware/bulkcheckout',
            'middleware' => 'authorize:assets.checkout',
            'uses' => 'AssetsController@postBulkCheckout'
        ]);
});


Route::resource('hardware', 'AssetsController', [
    'parameters' => ['asset' => 'asset_id']
]);
