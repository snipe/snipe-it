<?php


# Licenses
Route::group([ 'prefix' => 'licenses', 'middleware'=>'authorize:licenses.view' ], function () {

Route::get('create', [ 'as' => 'create/licenses', 'middleware' => 'authorize:licenses.create','uses' => 'LicensesController@getCreate' ]);
Route::post('create', [ 'as' => 'create/licenses', 'middleware' => 'authorize:licenses.create','uses' => 'LicensesController@postCreate' ]);
Route::get('{licenseId}/edit', [ 'as' => 'update/license', 'middleware' => 'authorize:licenses.edit', 'uses' => 'LicensesController@getEdit' ]);
Route::post('{licenseId}/edit', [ 'as' => 'update/license', 'middleware' => 'authorize:licenses.edit', 'uses' => 'LicensesController@postEdit' ]);
Route::get('{licenseId}/clone', [ 'as' => 'clone/license', 'middleware' => 'authorize:licenses.create', 'uses' => 'LicensesController@getClone' ]);
Route::post('{licenseId}/clone', [ 'as' => 'clone/license', 'middleware' => 'authorize:licenses.create', 'uses' => 'LicensesController@postCreate' ]);
Route::get('{licenseId}/delete', [ 'as' => 'delete/license', 'middleware' => 'authorize:licenses.delete', 'uses' => 'LicensesController@getDelete' ]);
Route::get('{licenseId}/freecheckout', [
'as' => 'freecheckout/license',
'middleware' => 'authorize:licenses.checkout',
'uses' => 'LicensesController@getFreeLicense'
]);
Route::get(
'{licenseId}/checkout',
[ 'as' => 'checkout/license', 'middleware' => 'authorize:licenses.checkout','uses' => 'LicensesController@getCheckout' ]
);
Route::post(
'{licenseId}/checkout',
[ 'as' => 'checkout/license', 'middleware' => 'authorize:licenses.checkout','uses' => 'LicensesController@postCheckout' ]
);
Route::get('{licenseId}/checkin/{backto?}', [
'as' => 'checkin/license',
'middleware' => 'authorize:licenses.checkin',
'uses' => 'LicensesController@getCheckin'
]);

Route::post('{licenseId}/checkin/{backto?}', [
'as' => 'checkin/license',
'middleware' => 'authorize:licenses.checkin',
'uses' => 'LicensesController@postCheckin'
]);

Route::get('{licenseId}/view', [
'as' => 'view/license',
'middleware' => 'authorize:licenses.view',
'uses' => 'LicensesController@getView'
]);

Route::post(
'{licenseId}/upload',
[ 'as' => 'upload/license', 'middleware' => 'authorize:licenses.edit','uses' => 'LicensesController@postUpload' ]
);
Route::get(
'{licenseId}/deletefile/{fileId}',
[ 'as' => 'delete/licensefile', 'middleware' => 'authorize:licenses.edit', 'uses' => 'LicensesController@getDeleteFile' ]
);
Route::get(
'{licenseId}/showfile/{fileId}',
[ 'as' => 'show/licensefile', 'middleware' => 'authorize:licenses.view','uses' => 'LicensesController@displayFile' ]
);
Route::get('/', [ 'as' => 'licenses', 'middleware' => 'authorize:licenses.view','uses' => 'LicensesController@getIndex' ]);
});

Route::resource('licenses', 'LicensesController', [
    'license' => ['license' => 'license_id']
]);
