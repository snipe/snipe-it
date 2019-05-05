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

        Route::get('audit/due', [
            'as' => 'assets.audit.due',
            'uses' => 'AssetsController@dueForAudit'
        ]);

        Route::get('audit/overdue', [
            'as' => 'assets.audit.overdue',
            'uses' => 'AssetsController@overdueForAudit'
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
            'uses' => 'AssetCheckoutController@create'
        ]);
        Route::post('{assetId}/checkout', [
            'as' => 'checkout/hardware',
            'uses' => 'AssetCheckoutController@store'
        ]);
        Route::get('{assetId}/checkin/{backto?}', [
            'as' => 'checkin/hardware',
            'uses' => 'AssetCheckinController@create'
        ]);

        Route::post('{assetId}/checkin/{backto?}', [
            'as' => 'checkin/hardware',
            'uses' => 'AssetCheckinController@store'
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
            'uses' => 'AssetFilesController@store'
        ]);

        Route::get('{assetId}/showfile/{fileId}/{download?}', [
            'as' => 'show/assetfile',
            'uses' => 'AssetFilesController@show'
        ]);

        Route::delete('{assetId}/showfile/{fileId}/delete', [
            'as' => 'delete/assetfile',
            'uses' => 'AssetFilesController@destroy'
        ]);


        Route::post(
            'bulkedit',
            [
                'as'   => 'hardware/bulkedit',
                'uses' => 'BulkAssetsController@edit'
            ]
        );
        Route::post(
            'bulkdelete',
            [
                'as'   => 'hardware/bulkdelete',
                'uses' => 'BulkAssetsController@destroy'
            ]
        );
        Route::post(
            'bulksave',
            [
                'as'   => 'hardware/bulksave',
                'uses' => 'BulkAssetsController@update'
            ]
        );

        # Bulk checkout / checkin
         Route::get( 'bulkcheckout',  [
                 'as' => 'hardware/bulkcheckout',
                 'uses' => 'BulkAssetsController@showCheckout'
         ]);
        Route::post( 'bulkcheckout',  [
            'as' => 'hardware/bulkcheckout',
            'uses' => 'BulkAssetsController@storeCheckout'
        ]);




});


Route::resource('hardware', 'AssetsController', [
    'middleware' => ['auth'],
    'parameters' => ['asset' => 'asset_id']
]);
