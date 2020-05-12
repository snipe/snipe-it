<?php


# Licenses
Route::group([ 'prefix' => 'licenses', 'middleware' => ['auth'] ], function () {

    Route::get('{licenseId}/clone', [ 'as' => 'clone/license', 'uses' => 'Licenses\LicensesController@getClone' ]);

    Route::get('{licenseId}/freecheckout', [
    'as' => 'licenses.freecheckout',
    'uses' => 'Licenses\LicensesController@getFreeLicense'
    ]);
    Route::get('{licenseId}/checkout/{seatId?}', [
    'as' => 'licenses.checkout',
    'uses' => 'Licenses\LicenseCheckoutController@create'
    ]);
    Route::post(
        '{licenseId}/checkout/{seatId?}',
        [ 'as' => 'licenses.checkout', 'uses' => 'Licenses\LicenseCheckoutController@store' ]
    );
    Route::get('{licenseSeatId}/checkin/{backto?}', [
    'as' => 'licenses.checkin',
    'uses' => 'Licenses\LicenseCheckinController@create'
    ]);

    Route::post('{licenseId}/checkin/{backto?}', [
    'as' => 'licenses.checkin.save',
    'uses' => 'Licenses\LicenseCheckinController@store'
    ]);

    Route::post(
    '{licenseId}/upload',
    [ 'as' => 'upload/license', 'uses' => 'Licenses\LicenseFilesController@store' ]
    );
    Route::delete(
    '{licenseId}/deletefile/{fileId}',
    [ 'as' => 'delete/licensefile', 'uses' => 'Licenses\LicenseFilesController@destroy' ]
    );
    Route::get(
    '{licenseId}/showfile/{fileId}/{download?}',
    [ 'as' => 'show.licensefile', 'uses' => 'Licenses\LicenseFilesController@show' ]
    );
});

Route::resource('licenses', 'Licenses\LicensesController', [
    'middleware' => ['auth'],
    'parameters' => ['license' => 'license_id']
]);
