<?php

/*
|--------------------------------------------------------------------------
| Asset Routes
|--------------------------------------------------------------------------
|
| Register all the asset routes.
|
*/

Route::group(array('prefix' => 'hardware', 'namespace' => 'Controllers\Admin', 'before' => 'admin-auth'), function () {



    Route::get('/', array(
    	'as' => 'hardware',
    	'uses' => 'AssetsController@getIndex')
    );

    Route::get('create/{model?}', array(
    	'as' => 'create/hardware',
    	'uses' => 'AssetsController@getCreate')
    );

    Route::post('create', array(
    	'as' => 'savenew/hardware',
    	'uses' => 'AssetsController@postCreate')
    );

    Route::get('{assetId}/edit', array(
    	'as' => 'update/hardware',
    	'uses' => 'AssetsController@getEdit')
    );

    Route::get('{assetId}/clone', array('as' => 'clone/hardware', 'uses' => 'AssetsController@getClone'));
    Route::post('{assetId}/clone', 'AssetsController@postCreate');
    Route::get('{assetId}/delete', array('as' => 'delete/hardware', 'uses' => 'AssetsController@getDelete'));
    Route::get('{assetId}/checkout', array('as' => 'checkout/hardware', 'uses' => 'AssetsController@getCheckout'));
    Route::post('{assetId}/checkout', 'AssetsController@postCheckout');
    Route::get('{assetId}/checkin', array('as' => 'checkin/hardware', 'uses' => 'AssetsController@getCheckin'));
    Route::post('{assetId}/checkin', 'AssetsController@postCheckin');
    Route::get('{assetId}/view', array('as' => 'view/hardware', 'uses' => 'AssetsController@getView'));
    Route::get('{assetId}/qr_code', array('as' => 'qr_code/hardware', 'uses' => 'AssetsController@getQrCode'));
    Route::get('{assetId}/restore', array('as' => 'restore/hardware', 'uses' => 'AssetsController@getRestore'));
    Route::post('{assetId}/upload', array('as' => 'upload/asset', 'uses' => 'AssetsController@postUpload'));
    Route::get('{assetId}/deletefile/{fileId}', array('as' => 'delete/assetfile', 'uses' => 'AssetsController@getDeleteFile'));
    Route::get('{assetId}/showfile/{fileId}', array('as' => 'show/assetfile', 'uses' => 'AssetsController@displayFile'));
    Route::post('{assetId}/edit', 'AssetsController@postEdit');
    
    Route::post('bulkedit', 
    	array('as' => 'hardware/bulkedit', 
    	'uses' => 'AssetsController@postBulkEdit'));
    Route::post('bulksave', 
    	array('as' => 'hardware/bulksave', 
    	'uses' => 'AssetsController@postBulkSave'));





# Asset Model Management
    Route::group(array('prefix' => 'models', 'before' => 'admin-auth'), function () {
        Route::get('/', array('as' => 'models', 'uses' => 'ModelsController@getIndex'));
        Route::get('create', array('as' => 'create/model', 'uses' => 'ModelsController@getCreate'));
        Route::post('create', 'ModelsController@postCreate');
        Route::get('{modelId}/edit', array('as' => 'update/model', 'uses' => 'ModelsController@getEdit'));
        Route::post('{modelId}/edit', 'ModelsController@postEdit');
        Route::get('{modelId}/clone', array('as' => 'clone/model', 'uses' => 'ModelsController@getClone'));
        Route::post('{modelId}/clone', 'ModelsController@postCreate');
        Route::get('{modelId}/delete', array('as' => 'delete/model', 'uses' => 'ModelsController@getDelete'));
        Route::get('{modelId}/view', array('as' => 'view/model', 'uses' => 'ModelsController@getView'));
        Route::get('{modelID}/restore', array('as' => 'restore/model', 'uses' => 'ModelsController@getRestore'));
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

Route::group(array('prefix' => 'admin', 'before' => 'admin-auth', 'namespace' => 'Controllers\Admin'), function () {


    # Licenses
    Route::group(array('prefix' => 'licenses'), function () {

        Route::get('create', array('as' => 'create/licenses', 'uses' => 'LicensesController@getCreate'));
        Route::post('create', 'LicensesController@postCreate');
        Route::get('{licenseId}/edit', array('as' => 'update/license', 'uses' => 'LicensesController@getEdit'));
        Route::post('{licenseId}/edit', 'LicensesController@postEdit');
        Route::get('{licenseId}/clone', array('as' => 'clone/license', 'uses' => 'LicensesController@getClone'));
        Route::post('{licenseId}/clone', 'LicensesController@postCreate');
        Route::get('{licenseId}/delete', array('as' => 'delete/license', 'uses' => 'LicensesController@getDelete'));
        Route::get('{licenseId}/checkout', array('as' => 'checkout/license', 'uses' => 'LicensesController@getCheckout'));
        Route::post('{licenseId}/checkout', 'LicensesController@postCheckout');
        Route::get('{licenseId}/checkin', array('as' => 'checkin/license', 'uses' => 'LicensesController@getCheckin'));
        Route::post('{licenseId}/checkin', 'LicensesController@postCheckin');
        Route::get('{licenseId}/view', array('as' => 'view/license', 'uses' => 'LicensesController@getView'));
        Route::post('{licenseId}/upload', array('as' => 'upload/license', 'uses' => 'LicensesController@postUpload'));
        Route::get('{licenseId}/deletefile/{fileId}', array('as' => 'delete/licensefile', 'uses' => 'LicensesController@getDeleteFile'));
        Route::get('{licenseId}/showfile/{fileId}', array('as' => 'show/licensefile', 'uses' => 'LicensesController@displayFile'));
        Route::get('/', array('as' => 'licenses', 'uses' => 'LicensesController@getIndex'));
    });
    
    # Accessories
        Route::group(array('prefix' => 'accessories'), function () {         
            Route::get('create', array('as' => 'create/accessory', 'uses' => 'AccessoriesController@getCreate'));
            Route::post('create', 'AccessoriesController@postCreate');
            Route::get('{accessoryID}/edit', array('as' => 'update/accessory', 'uses' => 'AccessoriesController@getEdit'));
            Route::post('{accessoryID}/edit', 'AccessoriesController@postEdit');
            Route::get('{accessoryID}/delete', array('as' => 'delete/accessory', 'uses' => 'AccessoriesController@getDelete'));
            Route::get('{accessoryID}/view', array('as' => 'view/accessory', 'uses' => 'AccessoriesController@getView'));
            Route::get('{accessoryID}/checkout', array('as' => 'checkout/accessory', 'uses' => 'AccessoriesController@getCheckout'));
		    Route::post('{accessoryID}/checkout', 'AccessoriesController@postCheckout');
		    Route::get('{accessoryID}/checkin', array('as' => 'checkin/accessory', 'uses' => 'AccessoriesController@getCheckin'));
		    Route::post('{accessoryID}/checkin', 'AccessoriesController@postCheckin');

            Route::get('/', array('as' => 'accessories', 'uses' => 'AccessoriesController@getIndex'));
        });



    # Admin Settings Routes (for categories, maufactureres, etc)
    Route::group(array('prefix' => 'settings'), function () {

        # Settings
        Route::group(array('prefix' => 'app'), function () {
            Route::get('/', array('as' => 'app', 'uses' => 'SettingsController@getIndex'));
            Route::get('edit', array('as' => 'edit/settings', 'uses' => 'SettingsController@getEdit'));
            Route::post('edit', 'SettingsController@postEdit');
        });

        # Manufacturers
        Route::group(array('prefix' => 'manufacturers'), function () {
            Route::get('/', array('as' => 'manufacturers', 'uses' => 'ManufacturersController@getIndex'));
            Route::get('create', array('as' => 'create/manufacturer', 'uses' => 'ManufacturersController@getCreate'));
            Route::post('create', 'ManufacturersController@postCreate');
            Route::get('{manufacturerId}/edit', array('as' => 'update/manufacturer', 'uses' => 'ManufacturersController@getEdit'));
            Route::post('{manufacturerId}/edit', 'ManufacturersController@postEdit');
            Route::get('{manufacturerId}/delete', array('as' => 'delete/manufacturer', 'uses' => 'ManufacturersController@getDelete'));
            Route::get('{manufacturerId}/view', array('as' => 'view/manufacturer', 'uses' => 'ManufacturersController@getView'));
        });

        # Suppliers
        Route::group(array('prefix' => 'suppliers'), function () {
            Route::get('/', array('as' => 'suppliers', 'uses' => 'SuppliersController@getIndex'));
            Route::get('create', array('as' => 'create/supplier', 'uses' => 'SuppliersController@getCreate'));
            Route::post('create', 'SuppliersController@postCreate');
            Route::get('{supplierId}/edit', array('as' => 'update/supplier', 'uses' => 'SuppliersController@getEdit'));
            Route::post('{supplierId}/edit', 'SuppliersController@postEdit');
            Route::get('{supplierId}/delete', array('as' => 'delete/supplier', 'uses' => 'SuppliersController@getDelete'));
            Route::get('{supplierId}/view', array('as' => 'view/supplier', 'uses' => 'SuppliersController@getView'));
        });        
        
         # Categories
        Route::group(array('prefix' => 'categories'), function () {          
            Route::get('create', array('as' => 'create/category', 'uses' => 'CategoriesController@getCreate'));
            Route::post('create', 'CategoriesController@postCreate');
            Route::get('{categoryId}/edit', array('as' => 'update/category', 'uses' => 'CategoriesController@getEdit'));
            Route::post('{categoryId}/edit', 'CategoriesController@postEdit');
            Route::get('{categoryId}/delete', array('as' => 'delete/category', 'uses' => 'CategoriesController@getDelete'));
            Route::get('{categoryId}/view', array('as' => 'view/category', 'uses' => 'CategoriesController@getView'));
            Route::get('/', array('as' => 'categories', 'uses' => 'CategoriesController@getIndex'));
        });


        # Depreciations
        Route::group(array('prefix' => 'depreciations'), function () {
            Route::get('/', array('as' => 'depreciations', 'uses' => 'DepreciationsController@getIndex'));
            Route::get('create', array('as' => 'create/depreciations', 'uses' => 'DepreciationsController@getCreate'));
            Route::post('create', 'DepreciationsController@postCreate');
            Route::get('{depreciationId}/edit', array('as' => 'update/depreciations', 'uses' => 'DepreciationsController@getEdit'));
            Route::post('{depreciationId}/edit', 'DepreciationsController@postEdit');
            Route::get('{depreciationId}/delete', array('as' => 'delete/depreciations', 'uses' => 'DepreciationsController@getDelete'));
        });

        # Locations
        Route::group(array('prefix' => 'locations'), function () {
            Route::get('/', array('as' => 'locations', 'uses' => 'LocationsController@getIndex'));
            Route::get('create', array('as' => 'create/location', 'uses' => 'LocationsController@getCreate'));
            Route::post('create', 'LocationsController@postCreate');
            Route::get('{locationId}/edit', array('as' => 'update/location', 'uses' => 'LocationsController@getEdit'));
            Route::post('{locationId}/edit', 'LocationsController@postEdit');
            Route::get('{locationId}/delete', array('as' => 'delete/location', 'uses' => 'LocationsController@getDelete'));
        });

        # Status Labels
        Route::group(array('prefix' => 'statuslabels'), function () {
            Route::get('/', array('as' => 'statuslabels', 'uses' => 'StatuslabelsController@getIndex'));
            Route::get('create', array('as' => 'create/statuslabel', 'uses' => 'StatuslabelsController@getCreate'));
            Route::post('create', 'StatuslabelsController@postCreate');
            Route::get('{statuslabelId}/edit', array('as' => 'update/statuslabel', 'uses' => 'StatuslabelsController@getEdit'));
            Route::post('{statuslabelId}/edit', 'StatuslabelsController@postEdit');
            Route::get('{statuslabelId}/delete', array('as' => 'delete/statuslabel', 'uses' => 'StatuslabelsController@getDelete'));
        });


    });



    # User Management
    Route::group(array('prefix' => 'users'), function () {
        Route::get('/', array('as' => 'users', 'uses' => 'UsersController@getIndex'));
        Route::get('create', array('as' => 'create/user', 'uses' => 'UsersController@getCreate'));
        Route::post('create', 'UsersController@postCreate');
        Route::get('import', array('as' => 'import/user', 'uses' => 'UsersController@getImport'));
        Route::post('import', 'UsersController@postImport');
        Route::get('{userId}/edit', array('as' => 'update/user', 'uses' => 'UsersController@getEdit'));
        Route::post('{userId}/edit', 'UsersController@postEdit');
        Route::get('{userId}/clone', array('as' => 'clone/user', 'uses' => 'UsersController@getClone'));
        Route::post('{userId}/clone', 'UsersController@postCreate');
        Route::get('{userId}/delete', array('as' => 'delete/user', 'uses' => 'UsersController@getDelete'));
        Route::get('{userId}/restore', array('as' => 'restore/user', 'uses' => 'UsersController@getRestore'));
        Route::get('{userId}/view', array('as' => 'view/user', 'uses' => 'UsersController@getView'));
        Route::get('{userId}/unsuspend', array('as' => 'unsuspend/user', 'uses' => 'UsersController@getUnsuspend'));


        Route::get('datatable', array('as' => 'api.users', 'uses' => 'UsersController@getDatatable'));
    });

    # Group Management
    Route::group(array('prefix' => 'groups'), function () {
        Route::get('/', array('as' => 'groups', 'uses' => 'GroupsController@getIndex'));
        Route::get('create', array('as' => 'create/group', 'uses' => 'GroupsController@getCreate'));
        Route::post('create', 'GroupsController@postCreate');
        Route::get('{groupId}/edit', array('as' => 'update/group', 'uses' => 'GroupsController@getEdit'));
        Route::post('{groupId}/edit', 'GroupsController@postEdit');
        Route::get('{groupId}/delete', array('as' => 'delete/group', 'uses' => 'GroupsController@getDelete'));
        Route::get('{groupId}/restore', array('as' => 'restore/group', 'uses' => 'GroupsController@getRestore'));
    });

    # Dashboard
    Route::get('/', array('as' => 'admin', 'uses' => 'DashboardController@getIndex'));

});

/*
|--------------------------------------------------------------------------
| Authentication and Authorization Routes
|--------------------------------------------------------------------------
|
|
|
*/

Route::group(array('prefix' => 'auth'), function () {

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

Route::group(array('prefix' => 'account', 'before' => 'auth', 'namespace' => 'Controllers\Account'), function () {

   
    # Profile
    Route::get('profile', array('as' => 'profile', 'uses' => 'ProfileController@getIndex'));
    Route::post('profile', 'ProfileController@postIndex');

    # Change Password
    Route::get('change-password', array('as' => 'change-password', 'uses' => 'ChangePasswordController@getIndex'));
    Route::post('change-password', 'ChangePasswordController@postIndex');

     # View Assets
    Route::get('view-assets', array('as' => 'view-assets', 'uses' => 'ViewAssetsController@getIndex'));

    # Change Email
    Route::get('change-email', array('as' => 'change-email', 'uses' => 'ChangeEmailController@getIndex'));
    Route::post('change-email', 'ChangeEmailController@postIndex');
    
     # Accept Asset
    Route::get('accept-asset/{logID}', array('as' => 'account/accept-assets', 'uses' => 'ViewAssetsController@getAcceptAsset'));
    Route::post('accept-asset/{logID}', array('as' => 'account/asset-accepted', 'uses' => 'ViewAssetsController@postAcceptAsset'));

    # Profile
    Route::get('requestable-assets', array('as' => 'requestable-assets', 'uses' => 'ViewAssetsController@getRequestableIndex'));
    Route::get('request-asset/{assetId}', array('as' => 'account/request-asset', 'uses' => 'ViewAssetsController@getRequestAsset'));
    
    # Account Dashboard
    Route::get('/', array('as' => 'account', 'uses' => 'DashboardController@getIndex'));


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

Route::group(array('before' => 'reporting-auth', 'namespace' => 'Controllers\Admin'), function () {

    Route::get('reports/depreciation', array('as' => 'reports/depreciation', 'uses' => 'ReportsController@getDeprecationReport'));
    Route::get('reports/export/depreciation', array('as' => 'reports/export/depreciation', 'uses' => 'ReportsController@exportDeprecationReport'));
    Route::get('reports/licenses', array('as' => 'reports/licenses', 'uses' => 'ReportsController@getLicenseReport'));
    Route::get('reports/export/licenses', array('as' => 'reports/export/licenses', 'uses' => 'ReportsController@exportLicenseReport'));
    Route::get('reports/assets', array('as' => 'reports/assets', 'uses' => 'ReportsController@getAssetsReport'));
    Route::get('reports/export/assets', array('as' => 'reports/export/assets', 'uses' => 'ReportsController@exportAssetReport'));

    Route::get('reports/custom', array('as' => 'reports/custom', 'uses' => 'ReportsController@getCustomReport'));
    Route::post('reports/custom', 'ReportsController@postCustom');
});



Route::get('/', array('as' => 'home', 'before' => 'admin-auth', 'uses' => 'Controllers\Admin\DashboardController@getIndex'));



