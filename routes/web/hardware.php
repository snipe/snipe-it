<?php

use App\Http\Controllers\AssetMaintenancesController;
use App\Http\Controllers\Assets\AssetsController;
use App\Http\Controllers\Assets\BulkAssetsController;
use App\Http\Controllers\Assets\AssetCheckoutController;
use App\Http\Controllers\Assets\AssetCheckinController;
use App\Http\Controllers\Assets\AssetFilesController;
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
    [
        'prefix' => 'hardware',
        'middleware' => ['auth'], 
    ],
    
    function () {
        
        Route::get('bulkaudit',
            [AssetsController::class, 'quickScan']
        )->name('assets.bulkaudit');

        Route::get('quickscancheckin',
            [AssetsController::class, 'quickScanCheckin']
        )->name('hardware/quickscancheckin');

        // Asset Maintenances
        Route::resource('maintenances', 
            AssetMaintenancesController::class, [
            'parameters' => ['maintenance' => 'maintenance_id', 'asset' => 'asset_id'],
        ]);

        Route::get('requested', [
            AssetsController::class, 'getRequestedIndex']
        )->name('assets.requested');

        Route::get('scan',
            [AssetsController::class, 'scan']
        )->name('asset.scan');

        Route::get('audit/due',
            [AssetsController::class, 'dueForAudit']
        )->name('assets.audit.due');

        Route::get('checkins/due',
            [AssetsController::class, 'dueForCheckin']
        )->name('assets.checkins.due');
        
        Route::get('audit/{id}',
            [AssetsController::class, 'audit']
        )->name('asset.audit.create');

        Route::post('audit/{id}',
            [AssetsController::class, 'auditStore']
        )->name('asset.audit.store');

        Route::get('history',
            [AssetsController::class, 'getImportHistory']
        )->name('asset.import-history');

        Route::post('history',
            [AssetsController::class, 'postImportHistory']
        )->name('asset.process-import-history');

        Route::get('bytag/{any?}',
            [AssetsController::class, 'getAssetByTag']
        )->where('any', '.*')->name('findbytag/hardware');

        Route::get('byserial/{any?}',
            [AssetsController::class, 'getAssetBySerial']
        )->where('any', '.*')->name('findbyserial/hardware');

        Route::get('{asset}/clone',
            [AssetsController::class, 'getClone']
        )->name('clone/hardware')->withTrashed();

        Route::get('{assetId}/label',
            [AssetsController::class, 'getLabel']
        )->name('label/hardware');
        

        Route::get('{assetId}/checkout',
            [AssetCheckoutController::class, 'create']
        )->name('hardware.checkout.create');

        Route::post('{assetId}/checkout',
            [AssetCheckoutController::class, 'store']
        )->name('hardware.checkout.store');

        Route::get('{assetId}/checkin/{backto?}',
            [AssetCheckinController::class, 'create']
        )->name('hardware.checkin.create');

        Route::post('{assetId}/checkin/{backto?}',
            [AssetCheckinController::class, 'store']
        )->name('hardware.checkin.store');

        // Redirect old legacy /asset_id/view urls to the resource route version
        Route::get('{assetId}/view', function ($assetId) {
            return redirect()->route('hardware.show', ['hardware' => $assetId]);
        });

        Route::get('{assetId}/qr_code', 
            [AssetsController::class, 'getQrCode']
        )->name('qr_code/hardware');

        Route::get('{assetId}/barcode', 
            [AssetsController::class, 'getBarCode']
        )->name('barcode/hardware');

        Route::post('{assetId}/restore',
            [AssetsController::class, 'getRestore']
        )->name('restore/hardware');

        Route::post('{assetId}/upload',
            [AssetFilesController::class, 'store']
        )->name('upload/asset');

        Route::get('{assetId}/showfile/{fileId}/{download?}',
            [AssetFilesController::class, 'show']
        )->name('show/assetfile');

        Route::delete('{assetId}/showfile/{fileId}/delete',
            [AssetFilesController::class, 'destroy']
        )->name('delete/assetfile');

        Route::post(
            'bulkedit',
            [BulkAssetsController::class, 'edit']
        )->name('hardware/bulkedit');

        Route::post(
            'bulkdelete',
            [BulkAssetsController::class, 'destroy']
        )->name('hardware/bulkdelete');

        Route::post(
            'bulkrestore',
            [BulkAssetsController::class, 'restore']
        )->name('hardware/bulkrestore');

        Route::post(
            'bulksave',
            [BulkAssetsController::class, 'update']
        )->name('hardware/bulksave');

        // Bulk checkout / checkin
        Route::get('bulkcheckout',
            [BulkAssetsController::class, 'showCheckout']
        )->name('hardware.bulkcheckout.show');

        Route::post('bulkcheckout',
            [BulkAssetsController::class, 'storeCheckout']
        )->name('hardware.bulkcheckout.store');

    });

Route::resource('hardware', 
        AssetsController::class, 
        [
            'middleware' => ['auth'],
            'parameters' => ['asset' => 'asset_id',
                'names' => [
                    'show' => 'view',
                ],
        ],
]);

Route::get('ht/{any?}',
    [AssetsController::class, 'getAssetByTag']
)->where('any', '.*')->name('ht/assetTag');
