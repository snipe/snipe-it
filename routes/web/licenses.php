<?php

use App\Http\Controllers\Licenses;
use Illuminate\Support\Facades\Route;

// Licenses
Route::group(['prefix' => 'licenses', 'middleware' => ['auth']], function () {
    Route::get('{licenseId}/clone', [Licenses\LicensesController::class, 'getClone'])->name('clone/license');

    Route::get('{licenseId}/freecheckout',
        [Licenses\LicensesController::class, 'getFreeLicense']
    )->name('licenses.freecheckout');
    Route::get('{licenseId}/checkout/{seatId?}', 
        [Licenses\LicenseCheckoutController::class, 'create']
    )->name('licenses.checkout');
    Route::post(
        '{licenseId}/checkout/{seatId?}',
        [Licenses\LicenseCheckoutController::class, 'store']
    ); //name() would duplicate here, so we skip it.
    Route::get('{licenseSeatId}/checkin/{backto?}',
        [Licenses\LicenseCheckinController::class, 'create']
    )->name('licenses.checkin');

    Route::post('{licenseId}/checkin/{backto?}',
        [Licenses\LicenseCheckinController::class, 'store']
    )->name('licenses.checkin.save');

    Route::post(
    '{licenseId}/upload',
        [Licenses\LicenseFilesController::class, 'store']
    )->name('upload/license');
    Route::delete(
    '{licenseId}/deletefile/{fileId}',
        [Licenses\LicenseFilesController::class, 'destroy']
    )->name('delete/licensefile');
    Route::get(
    '{licenseId}/showfile/{fileId}/{download?}',
        [Licenses\LicenseFilesController::class, 'show']
    )->name('show.licensefile');
});

Route::resource('licenses', Licenses\LicensesController::class, [
    'middleware' => ['auth'],
    'parameters' => ['license' => 'license_id'],
]);
