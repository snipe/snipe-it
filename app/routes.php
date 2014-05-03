<?php

/*
|--------------------------------------------------------------------------
| Asset Routes
|--------------------------------------------------------------------------
|
| Register all the asset routes.
|
*/

Route::group(array('prefix' => 'hardware'), function()
{

	Route::get('/', array('as' => '', 'uses' => 'Controllers\Admin\AssetsController@getIndex'));
	Route::get('/', array('as' => 'hardware', 'uses' => 'Controllers\Admin\AssetsController@getIndex'));
	Route::get('create', array('as' => 'create/hardware', 'uses' => 'Controllers\Admin\AssetsController@getCreate'));
	Route::post('create', 'Controllers\Admin\AssetsController@postCreate');
	Route::get('{assetId}/edit', array('as' => 'update/hardware', 'uses' => 'Controllers\Admin\AssetsController@getEdit'));
	Route::post('{assetId}/edit', 'Controllers\Admin\AssetsController@postEdit');
	Route::get('{assetId}/clone', array('as' => 'clone/hardware', 'uses' => 'Controllers\Admin\AssetsController@getClone'));
	Route::post('{assetId}/clone', 'Controllers\Admin\AssetsController@postCreate');
	Route::get('{assetId}/delete', array('as' => 'delete/hardware', 'uses' => 'Controllers\Admin\AssetsController@getDelete'));
	Route::get('{assetId}/checkout', array('as' => 'checkout/hardware', 'uses' => 'Controllers\Admin\AssetsController@getCheckout'));
	Route::post('{assetId}/checkout', 'Controllers\Admin\AssetsController@postCheckout');
	Route::get('{assetId}/checkin', array('as' => 'checkin/hardware', 'uses' => 'Controllers\Admin\AssetsController@getCheckin'));
	Route::post('{assetId}/checkin', 'Controllers\Admin\AssetsController@postCheckin');
	Route::get('{assetId}/view', array('as' => 'view/hardware', 'uses' => 'Controllers\Admin\AssetsController@getView'));
	Route::get('{assetId}/qr_code', array('as' => 'qr_code/hardware', 'uses' => 'Controllers\Admin\AssetsController@getQrCode'));


# Asset Model Management
	Route::group(array('prefix' => 'models'), function()
	{
		Route::get('/', array('as' => 'models', 'uses' => 'Controllers\Admin\ModelsController@getIndex'));
		Route::get('create', array('as' => 'create/model', 'uses' => 'Controllers\Admin\ModelsController@getCreate'));
		Route::post('create', 'Controllers\Admin\ModelsController@postCreate');
		Route::get('{modelId}/edit', array('as' => 'update/model', 'uses' => 'Controllers\Admin\ModelsController@getEdit'));
		Route::post('{modelId}/edit', 'Controllers\Admin\ModelsController@postEdit');
		Route::get('{modelId}/delete', array('as' => 'delete/model', 'uses' => 'Controllers\Admin\ModelsController@getDelete'));
		Route::get('{modelId}/view', array('as' => 'view/model', 'uses' => 'Controllers\Admin\ModelsController@getView'));
	});


});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Register all the admin routes.
|
*/

Route::group(array('prefix' => 'admin'), function()
{


	# Licenses
	Route::group(array('prefix' => 'licenses'), function()
	{
		Route::get('/', array('as' => 'licenses', 'uses' => 'Controllers\Admin\LicensesController@getIndex'));
		Route::get('create', array('as' => 'create/licenses', 'uses' => 'Controllers\Admin\LicensesController@getCreate'));
		Route::post('create', 'Controllers\Admin\LicensesController@postCreate');
		Route::get('{licenseId}/edit', array('as' => 'update/license', 'uses' => 'Controllers\Admin\LicensesController@getEdit'));
		Route::post('{licenseId}/edit', 'Controllers\Admin\LicensesController@postEdit');
		Route::get('{licenseId}/delete', array('as' => 'delete/license', 'uses' => 'Controllers\Admin\LicensesController@getDelete'));
		Route::get('{licenseId}/checkout', array('as' => 'checkout/license', 'uses' => 'Controllers\Admin\LicensesController@getCheckout'));
		Route::post('{licenseId}/checkout', 'Controllers\Admin\LicensesController@postCheckout');
		Route::get('{licenseId}/checkin', array('as' => 'checkin/license', 'uses' => 'Controllers\Admin\LicensesController@getCheckin'));
		Route::post('{licenseId}/checkin', 'Controllers\Admin\LicensesController@postCheckin');
		Route::get('{licenseId}/view', array('as' => 'view/license', 'uses' => 'Controllers\Admin\LicensesController@getView'));
	});


	# Admin Settings Routes (for categories, maufactureres, etc)
	Route::group(array('prefix' => 'settings'), function()
	{

		# Settings
		Route::group(array('prefix' => 'app'), function()
		{
			Route::get('/', array('as' => 'app', 'uses' => 'Controllers\Admin\SettingsController@getIndex'));
			Route::get('edit', array('as' => 'edit/settings', 'uses' => 'Controllers\Admin\SettingsController@getEdit'));
			Route::post('edit', 'Controllers\Admin\SettingsController@postEdit');
		});

		# Manufacturers
		Route::group(array('prefix' => 'manufacturers'), function()
		{
			Route::get('/', array('as' => 'manufacturers', 'uses' => 'Controllers\Admin\ManufacturersController@getIndex'));
			Route::get('create', array('as' => 'create/manufacturer', 'uses' => 'Controllers\Admin\ManufacturersController@getCreate'));
			Route::post('create', 'Controllers\Admin\ManufacturersController@postCreate');
			Route::get('{manufacturerId}/edit', array('as' => 'update/manufacturer', 'uses' => 'Controllers\Admin\ManufacturersController@getEdit'));
			Route::post('{manufacturerId}/edit', 'Controllers\Admin\ManufacturersController@postEdit');
			Route::get('{manufacturerId}/delete', array('as' => 'delete/manufacturer', 'uses' => 'Controllers\Admin\ManufacturersController@getDelete'));
		});

		# Categories
		Route::group(array('prefix' => 'categories'), function()
		{
			Route::get('/', array('as' => 'categories', 'uses' => 'Controllers\Admin\CategoriesController@getIndex'));
			Route::get('create', array('as' => 'create/category', 'uses' => 'Controllers\Admin\CategoriesController@getCreate'));
			Route::post('create', 'Controllers\Admin\CategoriesController@postCreate');
			Route::get('{categoryId}/edit', array('as' => 'update/category', 'uses' => 'Controllers\Admin\CategoriesController@getEdit'));
			Route::post('{categoryId}/edit', 'Controllers\Admin\CategoriesController@postEdit');
			Route::get('{categoryId}/delete', array('as' => 'delete/category', 'uses' => 'Controllers\Admin\CategoriesController@getDelete'));
		});

		# Depreciations
		Route::group(array('prefix' => 'depreciations'), function()
		{
			Route::get('/', array('as' => 'depreciations', 'uses' => 'Controllers\Admin\DepreciationsController@getIndex'));
			Route::get('create', array('as' => 'create/depreciations', 'uses' => 'Controllers\Admin\DepreciationsController@getCreate'));
			Route::post('create', 'Controllers\Admin\DepreciationsController@postCreate');
			Route::get('{depreciationId}/edit', array('as' => 'update/depreciations', 'uses' => 'Controllers\Admin\DepreciationsController@getEdit'));
			Route::post('{depreciationId}/edit', 'Controllers\Admin\DepreciationsController@postEdit');
			Route::get('{depreciationId}/delete', array('as' => 'delete/depreciations', 'uses' => 'Controllers\Admin\DepreciationsController@getDelete'));
		});

		# Locations
		Route::group(array('prefix' => 'locations'), function()
		{
			Route::get('/', array('as' => 'locations', 'uses' => 'Controllers\Admin\LocationsController@getIndex'));
			Route::get('create', array('as' => 'create/location', 'uses' => 'Controllers\Admin\LocationsController@getCreate'));
			Route::post('create', 'Controllers\Admin\LocationsController@postCreate');
			Route::get('{locationId}/edit', array('as' => 'update/location', 'uses' => 'Controllers\Admin\LocationsController@getEdit'));
			Route::post('{locationId}/edit', 'Controllers\Admin\LocationsController@postEdit');
			Route::get('{locationId}/delete', array('as' => 'delete/location', 'uses' => 'Controllers\Admin\LocationsController@getDelete'));
		});

		# Status Labels
		Route::group(array('prefix' => 'statuslabels'), function()
		{
			Route::get('/', array('as' => 'statuslabels', 'uses' => 'Controllers\Admin\StatuslabelsController@getIndex'));
			Route::get('create', array('as' => 'create/statuslabel', 'uses' => 'Controllers\Admin\StatuslabelsController@getCreate'));
			Route::post('create', 'Controllers\Admin\StatuslabelsController@postCreate');
			Route::get('{statuslabelId}/edit', array('as' => 'update/statuslabel', 'uses' => 'Controllers\Admin\StatuslabelsController@getEdit'));
			Route::post('{statuslabelId}/edit', 'Controllers\Admin\StatuslabelsController@postEdit');
			Route::get('{statuslabelId}/delete', array('as' => 'delete/statuslabel', 'uses' => 'Controllers\Admin\StatuslabelsController@getDelete'));
		});


	});



	# User Management
	Route::group(array('prefix' => 'users'), function()
	{
		Route::get('/', array('as' => 'users', 'uses' => 'Controllers\Admin\UsersController@getIndex'));
		Route::get('create', array('as' => 'create/user', 'uses' => 'Controllers\Admin\UsersController@getCreate'));
		Route::post('create', 'Controllers\Admin\UsersController@postCreate');
		Route::get('{userId}/edit', array('as' => 'update/user', 'uses' => 'Controllers\Admin\UsersController@getEdit'));
		Route::post('{userId}/edit', 'Controllers\Admin\UsersController@postEdit');
		Route::get('{userId}/delete', array('as' => 'delete/user', 'uses' => 'Controllers\Admin\UsersController@getDelete'));
		Route::get('{userId}/restore', array('as' => 'restore/user', 'uses' => 'Controllers\Admin\UsersController@getRestore'));
		Route::get('{userId}/view', array('as' => 'view/user', 'uses' => 'Controllers\Admin\UsersController@getView'));

		Route::get('datatable', array('as'=>'api.users', 'uses'=>'Controllers\Admin\UsersController@getDatatable'));
	});

	# Group Management
	Route::group(array('prefix' => 'groups'), function()
	{
		Route::get('/', array('as' => 'groups', 'uses' => 'Controllers\Admin\GroupsController@getIndex'));
		Route::get('create', array('as' => 'create/group', 'uses' => 'Controllers\Admin\GroupsController@getCreate'));
		Route::post('create', 'Controllers\Admin\GroupsController@postCreate');
		Route::get('{groupId}/edit', array('as' => 'update/group', 'uses' => 'Controllers\Admin\GroupsController@getEdit'));
		Route::post('{groupId}/edit', 'Controllers\Admin\GroupsController@postEdit');
		Route::get('{groupId}/delete', array('as' => 'delete/group', 'uses' => 'Controllers\Admin\GroupsController@getDelete'));
		Route::get('{groupId}/restore', array('as' => 'restore/group', 'uses' => 'Controllers\Admin\GroupsController@getRestore'));
	});

	# Dashboard
	Route::get('/', array('as' => 'admin', 'uses' => 'Controllers\Admin\DashboardController@getIndex'));

});

/*
|--------------------------------------------------------------------------
| Authentication and Authorization Routes
|--------------------------------------------------------------------------
|
|
|
*/

Route::group(array('prefix' => 'auth'), function()
{

	# Login
	Route::get('signin', array('as' => 'signin', 'uses' => 'AuthController@getSignin'));
	Route::post('signin', 'AuthController@postSignin');

	# Register
	#Route::get('signup', array('as' => 'signup', 'uses' => 'AuthController@getSignup'));
	Route::post('signup', 'AuthController@postSignup');

	# Account Activation
	Route::get('activate/{activationCode}', array('as' => 'activate', 'uses' => 'AuthController@getActivate'));

	# Forgot Password
	Route::get('forgot-password', array('as' => 'forgot-password', 'uses' => 'AuthController@getForgotPassword'));
	Route::post('forgot-password', 'AuthController@postForgotPassword');

	# Forgot Password Confirmation
	Route::get('forgot-password/{passwordResetCode}', array('as' => 'forgot-password-confirm', 'uses' => 'AuthController@getForgotPasswordConfirm'));
	Route::post('forgot-password/{passwordResetCode}', 'AuthController@postForgotPasswordConfirm');

	# Logout
	Route::get('logout', array('as' => 'logout', 'uses' => 'AuthController@getLogout'));

});

/*
|--------------------------------------------------------------------------
| Account Routes
|--------------------------------------------------------------------------
|
|
|
*/

Route::group(array('prefix' => 'account'), function()
{

	# Account Dashboard
	Route::get('/', array('as' => 'account', 'uses' => 'Controllers\Account\DashboardController@getIndex'));

	# Profile
	Route::get('profile', array('as' => 'profile', 'uses' => 'Controllers\Account\ProfileController@getIndex'));
	Route::post('profile', 'Controllers\Account\ProfileController@postIndex');

	# Change Password
	Route::get('change-password', array('as' => 'change-password', 'uses' => 'Controllers\Account\ChangePasswordController@getIndex'));
	Route::post('change-password', 'Controllers\Account\ChangePasswordController@postIndex');

	# Change Email
	Route::get('change-email', array('as' => 'change-email', 'uses' => 'Controllers\Account\ChangeEmailController@getIndex'));
	Route::post('change-email', 'Controllers\Account\ChangeEmailController@postIndex');

});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


// Redirect requests to / to the hardware section until we get a fancy dashboard set up
Route::get('/', function()
{
    return Redirect::to('hardware');
});
Route::get('/', array('as' => 'home', 'uses' => 'Controllers\Admin\AssetsController@getIndex'));
Route::get('reports', array('as' => 'reports', 'uses' => 'Controllers\Admin\AssetsController@getReports'));
Route::get('reports/export', array('as' => 'reports/export', 'uses' => 'Controllers\Admin\AssetsController@exportReports'));
