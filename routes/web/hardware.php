<?php

use App\Http\Controllers\AssetMaintenancesController;
use App\Http\Controllers\Assets;
use Illuminate\Support\Facades\Route;

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
    'middleware' => ['auth'], ],
    function () {
        Route::get('bulkaudit', [
            'as' => 'assets.bulkaudit',
            'uses' => [Assets\AssetsController::class, 'quickScan'],
        ]);

        // Asset Maintenances
        Route::resource('maintenances', AssetMaintenancesController::class, [
            'parameters' => ['maintenance' => 'maintenance_id', 'asset' => 'asset_id'],
        ]);

        Route::get('requested', ['as' => 'assets.requested', 'uses' => [Assets\AssetsController::class, 'getRequestedIndex']]);

        Route::get('scan', [
            'as' => 'asset.scan',
            'uses' => [Assets\AssetsController::class, 'scan'],
        ]);

        Route::get('audit/due', [
            'as' => 'assets.audit.due',
            'uses' => [Assets\AssetsController::class, 'dueForAudit'],
        ]);

        Route::get('audit/overdue', [
            'as' => 'assets.audit.overdue',
            'uses' => [Assets\AssetsController::class, 'overdueForAudit'],
        ]);

        Route::get('audit/due', [
            'as' => 'assets.audit.due',
            'uses' => [Assets\AssetsController::class, 'dueForAudit'],
        ]);

        Route::get('audit/overdue', [
            'as' => 'assets.audit.overdue',
            'uses' => [Assets\AssetsController::class, 'overdueForAudit'],
        ]);

        Route::get('audit/due', [
            'as' => 'assets.audit.due',
            'uses' => [Assets\AssetsController::class, 'dueForAudit'],
        ]);

        Route::get('audit/overdue', [
            'as' => 'assets.audit.overdue',
            'uses' => [Assets\AssetsController::class, 'overdueForAudit'],
        ]);

        Route::get('audit/{id}', [
            'as' => 'asset.audit.create',
            'uses' => [Assets\AssetsController::class, 'audit'],
        ]);

        Route::post('audit/{id}', [
            'as' => 'asset.audit.store',
            'uses' => [Assets\AssetsController::class, 'auditStore'],
        ]);

        Route::get('history', [
            'as' => 'asset.import-history',
            'uses' => [Assets\AssetsController::class, 'getImportHistory'],
        ]);

        Route::post('history', [
            'as' => 'asset.process-import-history',
            'uses' => [Assets\AssetsController::class, 'postImportHistory'],
        ]);

        Route::get('bytag/{any?}',
            [
                'as'   => 'findbytag/hardware',
                'uses' => [Assets\AssetsController::class, 'getAssetByTag'],
            ]
        )->where('any', '.*');

        Route::get('byserial/{any?}',
            [
                'as'   => 'findbyserial/hardware',
                'uses' => [Assets\AssetsController::class, 'getAssetBySerial'],
            ]
        )->where('any', '.*');

        Route::get('{assetId}/clone', [
            'as' => 'clone/hardware',
            'uses' => [Assets\AssetsController::class, 'getClone'],
        ]);

        Route::get('{assetId}/label', [
            'as' => 'label/hardware',
            'uses' => [Assets\AssetsController::class, 'getLabel'],
        ]);

        Route::post('{assetId}/clone', [Assets\AssetsController::class, 'postCreate']);

        Route::get('{assetId}/checkout', [
            'as' => 'checkout/hardware',
            'uses' => [Assets\AssetCheckoutController::class, 'create'],
        ]);
        Route::post('{assetId}/checkout', [
            'as' => 'checkout/hardware',
            'uses' => [Assets\AssetCheckoutController::class, 'store'],
        ]);
        Route::get('{assetId}/checkin/{backto?}', [
            'as' => 'checkin/hardware',
            'uses' => [Assets\AssetCheckinController::class, 'create'],
        ]);

        Route::post('{assetId}/checkin/{backto?}', [
            'as' => 'checkin/hardware',
            'uses' => [Assets\AssetCheckinController::class, 'store'],
        ]);
        Route::get('{assetId}/view', [
            'as' => 'hardware.view',
            'uses' => [Assets\AssetsController::class, 'show'],
        ]);
        Route::get('{assetId}/qr_code', ['as' => 'qr_code/hardware', 'uses' => [Assets\AssetsController::class, 'getQrCode']]);
        Route::get('{assetId}/barcode', ['as' => 'barcode/hardware', 'uses' => [Assets\AssetsController::class, 'getBarCode']]);
        Route::get('{assetId}/restore', [
            'as' => 'restore/hardware',
            'uses' => [Assets\AssetsController::class, 'getRestore'],
        ]);
        Route::post('{assetId}/upload', [
            'as' => 'upload/asset',
            'uses' => [Assets\AssetFilesController::class, 'store'],
        ]);

        Route::get('{assetId}/showfile/{fileId}/{download?}', [
            'as' => 'show/assetfile',
            'uses' => [Assets\AssetFilesController::class, 'show'],
        ]);

        Route::delete('{assetId}/showfile/{fileId}/delete', [
            'as' => 'delete/assetfile',
            'uses' => [Assets\AssetFilesController::class, 'destroy'],
        ]);

        Route::post(
            'bulkedit',
            [
                'as'   => 'hardware/bulkedit',
                'uses' => [Assets\BulkAssetsController::class, 'edit'],
            ]
        );
        Route::post(
            'bulkdelete',
            [
                'as'   => 'hardware/bulkdelete',
                'uses' => [Assets\BulkAssetsController::class, 'destroy'],
            ]
        );
        Route::post(
            'bulksave',
            [
                'as'   => 'hardware/bulksave',
                'uses' => [Assets\BulkAssetsController::class, 'update'],
            ]
        );

        // Bulk checkout / checkin
        Route::get('bulkcheckout', [
                 'as' => 'hardware/bulkcheckout',
                 'uses' => [Assets\BulkAssetsController::class, 'showCheckout'],
         ]);
        Route::post('bulkcheckout', [
            'as' => 'hardware/bulkcheckout',
            'uses' => [Assets\BulkAssetsController::class, 'storeCheckout'],
        ]);
    });

Route::resource('hardware', Assets\AssetsController::class, [
    'middleware' => ['auth'],
    'parameters' => ['asset' => 'asset_id'],
]);
