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
    'middleware' => ['auth']],
    function () {

        Route::get( 'bulkaudit',  [
            'as' => 'assets.bulkaudit',
            'uses' => 'AssetsController@quickScan'
        ]);

        # Asset Maintenances
        Route::resource('maintenances', 'AssetMaintenancesController', [
            'parameters' => ['maintenance' => 'maintenance_id', 'asset' => 'asset_id']
        ]);

        Route::get('requested', [ 'as' => 'assets.requested', 'uses' => 'AssetsController@getRequestedIndex']);

        Route::get('scan', [
            'as' => 'asset.scan',
            'uses' => 'AssetsController@scan'
        ]);

        Route::get('audit/{id}', [
            'as' => 'asset.audit.create',
            'uses' => 'AssetsController@audit'
        ]);

        Route::post('audit/{id}', [
            'as' => 'asset.audit.store',
            'uses' => 'AssetsController@auditStore'
        ]);


        Route::get('history', [
            'as' => 'asset.import-history',
            'uses' => 'AssetsController@getImportHistory'
        ]);

        Route::post('history', [
            'as' => 'asset.process-import-history',
            'uses' => 'AssetsController@postImportHistory'
        ]);

        Route::get('/bytag', [
            'as'   => 'findbytag/hardware',
            'uses' => 'AssetsController@getAssetByTag'
        ]);

        Route::get('{assetId}/clone', [
            'as' => 'clone/hardware',
            'uses' => 'AssetsController@getClone'
        ]);

        Route::post('{assetId}/clone', 'AssetsController@postCreate');

        Route::get('{assetId}/checkout', [
            'as' => 'checkout/hardware',
            'uses' => 'AssetsController@getCheckout'
        ]);
        Route::post('{assetId}/checkout', [
            'as' => 'checkout/hardware',
            'uses' => 'AssetsController@postCheckout'
        ]);
        Route::get('{assetId}/checkin/{backto?}', [
            'as' => 'checkin/hardware',
            'uses' => 'AssetsController@getCheckin'
        ]);

        Route::post('{assetId}/checkin/{backto?}', [
            'as' => 'checkin/hardware',
            'uses' => 'AssetsController@postCheckin'
        ]);
        Route::get('{assetId}/view', [
            'as' => 'hardware.view',
            'uses' => 'AssetsController@show'
        ]);
        Route::get('{assetId}/qr_code', [ 'as' => 'qr_code/hardware', 'uses' => 'AssetsController@getQrCode' ]);
        Route::get('{assetId}/barcode', [ 'as' => 'barcode/hardware', 'uses' => 'AssetsController@getBarCode' ]);
        Route::get('{assetId}/restore', [
            'as' => 'restore/hardware',
            'uses' => 'AssetsController@getRestore'
        ]);
        Route::post('{assetId}/upload', [
            'as' => 'upload/asset',
            'uses' => 'AssetsController@postUpload'
        ]);

        Route::get('{assetId}/showfile/{fileId}', [
            'as' => 'show/assetfile',
            'uses' => 'AssetsController@displayFile'
        ]);

        Route::delete('{assetId}/showfile/{fileId}/delete', [
            'as' => 'delete/assetfile',
            'uses' => 'AssetsController@deleteFile'
        ]);


        Route::post(
            'bulkedit',
            [
                'as'   => 'hardware/bulkedit',
                'uses' => 'AssetsController@postBulkEdit'
            ]
        );
        Route::post(
            'bulkdelete',
            [
                'as'   => 'hardware/bulkdelete',
                'uses' => 'AssetsController@postBulkDelete'
            ]
        );
        Route::post(
            'bulksave',
            [
                'as'   => 'hardware/bulksave',
                'uses' => 'AssetsController@postBulkSave'
            ]
        );

        # Bulk checkout / checkin
         Route::get( 'bulkcheckout',  [
                 'as' => 'hardware/bulkcheckout',
                 'uses' => 'AssetsController@getBulkCheckout'
         ]);
        Route::post( 'bulkcheckout',  [
            'as' => 'hardware/bulkcheckout',
            'uses' => 'AssetsController@postBulkCheckout'
        ]);




});


Route::resource('hardware', 'AssetsController', [
    'middleware' => ['auth'],
    'parameters' => ['asset' => 'asset_id']
]);
