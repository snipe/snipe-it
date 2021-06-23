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
        Route::get('bulkaudit',
            [Assets\AssetsController::class, 'quickScan']
        )->name('assets.bulkaudit');

        // Asset Maintenances
        Route::resource('maintenances', AssetMaintenancesController::class, [
            'parameters' => ['maintenance' => 'maintenance_id', 'asset' => 'asset_id'],
        ]);

        Route::get('requested', [Assets\AssetsController::class, 'getRequestedIndex'])->name('assets.requested');

        Route::get('scan',
            [Assets\AssetsController::class, 'scan']
        )->name('asset.scan');

        Route::get('audit/due',
            [Assets\AssetsController::class, 'dueForAudit']
        )->name('assets.audit.due');

        Route::get('audit/overdue',
            [Assets\AssetsController::class, 'overdueForAudit']
        )->name('assets.audit.overdue');

        Route::get('audit/due',
            [Assets\AssetsController::class, 'dueForAudit']
        )->name('assets.audit.due');

        Route::get('audit/overdue',
            [Assets\AssetsController::class, 'overdueForAudit']
        )->name('assets.audit.overdue');

        Route::get('audit/due',
            [Assets\AssetsController::class, 'dueForAudit']
        )->name('assets.audit.due');

        Route::get('audit/overdue',
            [Assets\AssetsController::class, 'overdueForAudit']
        )->name('assets.audit.overdue');

        Route::get('audit/{id}',
            [Assets\AssetsController::class, 'audit']
        )->name('asset.audit.create');

        Route::post('audit/{id}',
            [Assets\AssetsController::class, 'auditStore']
        )->name('asset.audit.store');

        Route::get('history',
            [Assets\AssetsController::class, 'getImportHistory']
        )->name('asset.import-history');

        Route::post('history',
            [Assets\AssetsController::class, 'postImportHistory']
        )->name('asset.process-import-history');

        Route::get('bytag/{any?}',
            [Assets\AssetsController::class, 'getAssetByTag']
        )->where('any', '.*')->name('findbytag/hardware');

        Route::get('byserial/{any?}',
            [Assets\AssetsController::class, 'getAssetBySerial']
        )->where('any', '.*')->name('findbyserial/hardware');

        Route::get('{assetId}/clone',
            [Assets\AssetsController::class, 'getClone']
        )->name('clone/hardware');

        Route::get('{assetId}/label',
            [Assets\AssetsController::class, 'getLabel']
        )->name('label/hardware');

        Route::post('{assetId}/clone', [Assets\AssetsController::class, 'postCreate']);

        Route::get('{assetId}/checkout',
            [Assets\AssetCheckoutController::class, 'create']
        )->name('checkout/hardware');
        Route::post('{assetId}/checkout',
            [Assets\AssetCheckoutController::class, 'store']
        )->name('checkout/hardware');
        Route::get('{assetId}/checkin/{backto?}',
            [Assets\AssetCheckinController::class, 'create']
        )->name('checkin/hardware');

        Route::post('{assetId}/checkin/{backto?}',
            [Assets\AssetCheckinController::class, 'store']
        )->name('checkin/hardware');
        Route::get('{assetId}/view',
            [Assets\AssetsController::class, 'show']
        )->name('hardware.view');
        Route::get('{assetId}/qr_code', [Assets\AssetsController::class, 'getQrCode'])->name('qr_code/hardware');
        Route::get('{assetId}/barcode', [Assets\AssetsController::class, 'getBarCode'])->name('barcode/hardware');
        Route::get('{assetId}/restore',
            [Assets\AssetsController::class, 'getRestore']
        )->name('restore/hardware');
        Route::post('{assetId}/upload',
            [Assets\AssetFilesController::class, 'store']
        )->name('upload/asset');

        Route::get('{assetId}/showfile/{fileId}/{download?}',
            [Assets\AssetFilesController::class, 'show']
        )->name('show/assetfile');

        Route::delete('{assetId}/showfile/{fileId}/delete',
            [Assets\AssetFilesController::class, 'destroy']
        )->name('delete/assetfile');

        Route::post(
            'bulkedit',
            [Assets\BulkAssetsController::class, 'edit']
        )->name('hardware/bulkedit');
        Route::post(
            'bulkdelete',
            [Assets\BulkAssetsController::class, 'destroy']
        )->name('hardware/bulkdelete');
        Route::post(
            'bulksave',
            [Assets\BulkAssetsController::class, 'update']
        )->name('hardware/bulksave');

        // Bulk checkout / checkin
        Route::get('bulkcheckout',
            [Assets\BulkAssetsController::class, 'showCheckout']
        )->name('hardware/bulkcheckout');
        Route::post('bulkcheckout',
            [Assets\BulkAssetsController::class, 'storeCheckout']
        )->name('hardware/bulkcheckout');
    });

Route::resource('hardware', Assets\AssetsController::class, [
    'middleware' => ['auth'],
    'parameters' => ['asset' => 'asset_id'],
]);
