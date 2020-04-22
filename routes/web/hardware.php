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
            'uses' => 'Assets\AssetsController@quickScan'
        ]);

        # Asset Maintenances
        Route::resource('maintenances', 'AssetMaintenancesController', [
            'parameters' => ['maintenance' => 'maintenance_id', 'asset' => 'asset_id']
        ]);

        Route::get('requested', [ 'as' => 'assets.requested', 'uses' => 'Assets\AssetsController@getRequestedIndex']);

        Route::get('scan', [
            'as' => 'asset.scan',
            'uses' => 'Assets\AssetsController@scan'
        ]);

        Route::get('audit/due', [
            'as' => 'assets.audit.due',
            'uses' => 'Assets\AssetsController@dueForAudit'
        ]);

        Route::get('audit/overdue', [
            'as' => 'assets.audit.overdue',
            'uses' => 'Assets\AssetsController@overdueForAudit'
        ]);

        Route::get('audit/due', [
            'as' => 'assets.audit.due',
            'uses' => 'Assets\AssetsController@dueForAudit'
        ]);

        Route::get('audit/overdue', [
            'as' => 'assets.audit.overdue',
            'uses' => 'Assets\AssetsController@overdueForAudit'
        ]);

        Route::get('audit/due', [
            'as' => 'assets.audit.due',
            'uses' => 'Assets\AssetsController@dueForAudit'
        ]);

        Route::get('audit/overdue', [
            'as' => 'assets.audit.overdue',
            'uses' => 'Assets\AssetsController@overdueForAudit'
        ]);

        Route::get('audit/{id}', [
            'as' => 'asset.audit.create',
            'uses' => 'Assets\AssetsController@audit'
        ]);

        Route::post('audit/{id}', [
            'as' => 'asset.audit.store',
            'uses' => 'Assets\AssetsController@auditStore'
        ]);


        Route::get('history', [
            'as' => 'asset.import-history',
            'uses' => 'Assets\AssetsController@getImportHistory'
        ]);

        Route::post('history', [
            'as' => 'asset.process-import-history',
            'uses' => 'Assets\AssetsController@postImportHistory'
        ]);

        Route::get('bytag/{any?}',
            [
                'as'   => 'findbytag/hardware',
                'uses' => 'Assets\AssetsController@getAssetByTag'
            ]
        )->where('any', '.*');

        Route::get('byserial/{any?}',
            [
                'as'   => 'findbyserial/hardware',
                'uses' => 'Assets\AssetsController@getAssetBySerial'
            ]
        )->where('any', '.*');



        Route::get('{assetId}/clone', [
            'as' => 'clone/hardware',
            'uses' => 'Assets\AssetsController@getClone'
        ]);

        Route::get('{assetId}/label', [
            'as' => 'label/hardware',
            'uses' => 'Assets\AssetsController@getLabel'
        ]);

        Route::post('{assetId}/clone', 'Assets\AssetsController@postCreate');

        Route::get('{assetId}/checkout', [
            'as' => 'checkout/hardware',
            'uses' => 'Assets\AssetCheckoutController@create'
        ]);
        Route::post('{assetId}/checkout', [
            'as' => 'checkout/hardware',
            'uses' => 'Assets\AssetCheckoutController@store'
        ]);
        Route::get('{assetId}/checkin/{backto?}', [
            'as' => 'checkin/hardware',
            'uses' => 'Assets\AssetCheckinController@create'
        ]);

        Route::post('{assetId}/checkin/{backto?}', [
            'as' => 'checkin/hardware',
            'uses' => 'Assets\AssetCheckinController@store'
        ]);
        Route::get('{assetId}/view', [
            'as' => 'hardware.view',
            'uses' => 'Assets\AssetsController@show'
        ]);
        Route::get('{assetId}/qr_code', [ 'as' => 'qr_code/hardware', 'uses' => 'Assets\AssetsController@getQrCode' ]);
        Route::get('{assetId}/barcode', [ 'as' => 'barcode/hardware', 'uses' => 'Assets\AssetsController@getBarCode' ]);
        Route::get('{assetId}/restore', [
            'as' => 'restore/hardware',
            'uses' => 'Assets\AssetsController@getRestore'
        ]);
        Route::post('{assetId}/upload', [
            'as' => 'upload/asset',
            'uses' => 'Assets\AssetFilesController@store'
        ]);

        Route::get('{assetId}/showfile/{fileId}/{download?}', [
            'as' => 'show/assetfile',
            'uses' => 'Assets\AssetFilesController@show'
        ]);

        Route::delete('{assetId}/showfile/{fileId}/delete', [
            'as' => 'delete/assetfile',
            'uses' => 'Assets\AssetFilesController@destroy'
        ]);


        Route::post(
            'bulkedit',
            [
                'as'   => 'hardware/bulkedit',
                'uses' => 'Assets\BulkAssetsController@edit'
            ]
        );
        Route::post(
            'bulkdelete',
            [
                'as'   => 'hardware/bulkdelete',
                'uses' => 'Assets\BulkAssetsController@destroy'
            ]
        );
        Route::post(
            'bulksave',
            [
                'as'   => 'hardware/bulksave',
                'uses' => 'Assets\BulkAssetsController@update'
            ]
        );

        # Bulk checkout / checkin
         Route::get( 'bulkcheckout',  [
                 'as' => 'hardware/bulkcheckout',
                 'uses' => 'Assets\BulkAssetsController@showCheckout'
         ]);
        Route::post( 'bulkcheckout',  [
            'as' => 'hardware/bulkcheckout',
            'uses' => 'Assets\BulkAssetsController@storeCheckout'
        ]);




});


Route::resource('hardware', 'Assets\AssetsController', [
    'middleware' => ['auth'],
    'parameters' => ['asset' => 'asset_id']
]);
