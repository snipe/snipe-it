<?php

use App\Http\Controllers\Licenses;
use Illuminate\Support\Facades\Route;

// Licenses
Route::group(['prefix' => 'licenses', 'middleware' => ['auth']], function () {
    Route::get('{licenseId}/clone', ['as' => 'clone/license', 'uses' => [Licenses\LicensesController::class, 'getClone']]);

    Route::get('{licenseId}/freecheckout', [
    'as' => 'licenses.freecheckout',
    'uses' => [Licenses\LicensesController::class, 'getFreeLicense'],
    ]);
    Route::get('{licenseId}/checkout/{seatId?}', [
    'as' => 'licenses.checkout',
    'uses' => [Licenses\LicenseCheckoutController::class, 'create'],
    ]);
    Route::post(
        '{licenseId}/checkout/{seatId?}',
        ['as' => 'licenses.checkout', 'uses' => [Licenses\LicenseCheckoutController::class, 'store']]
    );
    Route::get('{licenseSeatId}/checkin/{backto?}', [
    'as' => 'licenses.checkin',
    'uses' => [Licenses\LicenseCheckinController::class, 'create'],
    ]);

    Route::post('{licenseId}/checkin/{backto?}', [
    'as' => 'licenses.checkin.save',
    'uses' => [Licenses\LicenseCheckinController::class, 'store'],
    ]);

    Route::post(
    '{licenseId}/upload',
    ['as' => 'upload/license', 'uses' => [Licenses\LicenseFilesController::class, 'store']]
    );
    Route::delete(
    '{licenseId}/deletefile/{fileId}',
    ['as' => 'delete/licensefile', 'uses' => [Licenses\LicenseFilesController::class, 'destroy']]
    );
    Route::get(
    '{licenseId}/showfile/{fileId}/{download?}',
    ['as' => 'show.licensefile', 'uses' => [Licenses\LicenseFilesController::class, 'show']]
    );
});

Route::resource('licenses', Licenses\LicensesController::class, [
    'middleware' => ['auth'],
    'parameters' => ['license' => 'license_id'],
]);
