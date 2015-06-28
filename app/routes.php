<?php
/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
*/
Route::group(array('prefix' => 'api', 'namespace' => 'Controllers\Admin', 'before' => 'admin-auth'), function () {
    /*---Hardware API---*/
    Route::group(['prefix' => 'hardware'], function() {
        Route::resource('/', 'AssetsController');
        Route::get('list/{status?}', ['as'=>'api.hardware.list', 'uses'=>'AssetsController@getDatatable']);
    });
    /*---Accessories API---*/
    Route::group(['prefix'=>'accessories'], function () {
        Route::resource('/', 'AccessoriesController');
        Route::get('list', ['as'=>'api.accessories.list', 'uses'=>'AccessoriesController@getDatatable']);
        Route::get('{accessoryID}/view', ['as'=>'api.accessories.view', 'uses'=>'AccessoriesController@getDataView']);
    });
    /*---Users API---*/
    Route::group(['prefix'=>'users'], function() {
        Route::resource('/', 'UsersController');
        Route::get('list/{status?}', ['as'=>'api.users.list', 'uses'=>'UsersController@getDatatable']);
    });
    /*---Licenses API---*/
    Route::group(['prefix'=>'licenses'], function() {
        Route::resource('/', 'LicensesController');
        Route::get('list', ['as'=>'api.licenses.list', 'uses'=>'LicensesController@getDatatable']);
    });
    /*---Improvements API---*/
    Route::group( [ 'prefix' => 'improvements' ], function () {

        Route::resource( '/', 'ImprovementsController' );
        Route::get( 'list', [ 'as' => 'api.improvements.list', 'uses' => 'ImprovementsController@getDatatable' ] );
    } );
    /*---Models API---*/
    Route::group( [ 'prefix' => 'models'], function() {
        Route::resource('/', 'ModelsController');
        Route::get('list/{status?}', ['as'=>'api.models.list', 'uses'=>'ModelsController@getDatatable']);
        Route::get('{modelId}/check', function ($modelId) {
			 $model = Model::find($modelId);
			 return $model->show_mac_address;
		});

        Route::get('{modelID}/view', ['as'=>'api.models.view', 'uses'=>'ModelsController@getDataView']);
    });
    /*--- Categories API---*/
    Route::group(['prefix'=>'categories'], function() {
        Route::resource('/', 'CategoriesController');
        Route::get('list', ['as'=>'api.categories.list', 'uses'=>'CategoriesController@getDatatable']);
        Route::get('{categoryID}/view', ['as'=>'api.categories.view', 'uses'=>'CategoriesController@getDataView']);
    });
});

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
    Route::get('{assetId}/checkin/{backto?}', array('as' => 'checkin/hardware', 'uses' => 'AssetsController@getCheckin'));
    Route::post('{assetId}/checkin/{backto?}', 'AssetsController@postCheckin');
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
    Route::group(['prefix' => 'licenses'], function () {

        Route::get('create', ['as' => 'create/licenses', 'uses' => 'LicensesController@getCreate']);
        Route::post('create', 'LicensesController@postCreate');
        Route::get('{licenseId}/edit', ['as' => 'update/license', 'uses' => 'LicensesController@getEdit']);
        Route::post('{licenseId}/edit', 'LicensesController@postEdit');
        Route::get('{licenseId}/clone', ['as' => 'clone/license', 'uses' => 'LicensesController@getClone']);
        Route::post('{licenseId}/clone', 'LicensesController@postCreate');
        Route::get('{licenseId}/delete', ['as' => 'delete/license', 'uses' => 'LicensesController@getDelete']);
        Route::get('{licenseId}/checkout', ['as' => 'checkout/license', 'uses' => 'LicensesController@getCheckout']);
        Route::post('{licenseId}/checkout', 'LicensesController@postCheckout');
        Route::get('{licenseId}/checkin/{backto?}', ['as' => 'checkin/license', 'uses' => 'LicensesController@getCheckin']);
        Route::post('{licenseId}/checkin/{backto?}', 'LicensesController@postCheckin');
        Route::get('{licenseId}/view', ['as' => 'view/license', 'uses' => 'LicensesController@getView']);
        Route::post('{licenseId}/upload', ['as' => 'upload/license', 'uses' => 'LicensesController@postUpload']);
        Route::get('{licenseId}/deletefile/{fileId}', ['as' => 'delete/licensefile', 'uses' => 'LicensesController@getDeleteFile']);
        Route::get('{licenseId}/showfile/{fileId}', ['as' => 'show/licensefile', 'uses' => 'LicensesController@displayFile']);
        Route::get('/', ['as' => 'licenses', 'uses' => 'LicensesController@getIndex']);
    });

    # Improvements
    Route::group( [ 'prefix' => 'improvements' ], function () {

        Route::get( 'create/{assetId?}', [ 'as' => 'create/improvements', 'uses' => 'ImprovementsController@getCreate' ] );
        Route::post( 'create/{assetId?}', 'ImprovementsController@postCreate' );
        Route::get( '/', [ 'as' => 'improvements', 'uses' => 'ImprovementsController@getIndex' ] );
        Route::get( '{improvementId}/edit',
            [ 'as' => 'update/improvement', 'uses' => 'ImprovementsController@getEdit' ] );
        Route::post( '{improvementId}/edit', 'ImprovementsController@postEdit' );
        Route::get('{improvementId}/delete', array('as' => 'delete/improvement', 'uses' => 'ImprovementsController@getDelete'));
        Route::get('{improvementId}/view', array('as' => 'view/improvement', 'uses' => 'ImprovementsController@getView'));
    } );

    # Accessories
    Route::group( [ 'prefix' => 'accessories' ], function () {

            Route::get('create', ['as' => 'create/accessory', 'uses' => 'AccessoriesController@getCreate']);
            Route::post('create', 'AccessoriesController@postCreate');
            Route::get('{accessoryID}/edit', ['as' => 'update/accessory', 'uses' => 'AccessoriesController@getEdit']);
            Route::post('{accessoryID}/edit', 'AccessoriesController@postEdit');
            Route::get('{accessoryID}/delete', ['as' => 'delete/accessory', 'uses' => 'AccessoriesController@getDelete']);
            Route::get('{accessoryID}/view', ['as' => 'view/accessory', 'uses' => 'AccessoriesController@getView']);
            Route::get('{accessoryID}/checkout', ['as' => 'checkout/accessory', 'uses' => 'AccessoriesController@getCheckout']);
		    Route::post('{accessoryID}/checkout', 'AccessoriesController@postCheckout');
		    Route::get('{accessoryID}/checkin/{backto?}', ['as' => 'checkin/accessory', 'uses' => 'AccessoriesController@getCheckin']);
		    Route::post('{accessoryID}/checkin/{backto?}', 'AccessoriesController@postCheckin');

            Route::get('/', ['as' => 'accessories', 'uses' => 'AccessoriesController@getIndex']);
        });



    # Admin Settings Routes (for categories, maufactureres, etc)
    Route::group(['prefix' => 'settings'], function () {

        # Settings
        Route::group(['prefix' => 'app'], function () {
            Route::get('/', ['as' => 'app', 'uses' => 'SettingsController@getIndex']);
            Route::get('edit', ['as' => 'edit/settings', 'uses' => 'SettingsController@getEdit']);
            Route::post('edit', 'SettingsController@postEdit');
        });

        # Manufacturers
        Route::group(['prefix' => 'manufacturers'], function () {
            Route::get('/', ['as' => 'manufacturers', 'uses' => 'ManufacturersController@getIndex']);
            Route::get('create', ['as' => 'create/manufacturer', 'uses' => 'ManufacturersController@getCreate']);
            Route::post('create', 'ManufacturersController@postCreate');
            Route::get('{manufacturerId}/edit', ['as' => 'update/manufacturer', 'uses' => 'ManufacturersController@getEdit']);
            Route::post('{manufacturerId}/edit', 'ManufacturersController@postEdit');
            Route::get('{manufacturerId}/delete', ['as' => 'delete/manufacturer', 'uses' => 'ManufacturersController@getDelete']);
            Route::get('{manufacturerId}/view', ['as' => 'view/manufacturer', 'uses' => 'ManufacturersController@getView']);
        });

        # Suppliers
        Route::group(['prefix' => 'suppliers'], function () {
            Route::get('/', ['as' => 'suppliers', 'uses' => 'SuppliersController@getIndex']);
            Route::get('create', ['as' => 'create/supplier', 'uses' => 'SuppliersController@getCreate']);
            Route::post('create', 'SuppliersController@postCreate');
            Route::get('{supplierId}/edit', ['as' => 'update/supplier', 'uses' => 'SuppliersController@getEdit']);
            Route::post('{supplierId}/edit', 'SuppliersController@postEdit');
            Route::get('{supplierId}/delete', ['as' => 'delete/supplier', 'uses' => 'SuppliersController@getDelete']);
            Route::get('{supplierId}/view', ['as' => 'view/supplier', 'uses' => 'SuppliersController@getView']);
        });

         # Categories
        Route::group(['prefix' => 'categories'], function () {
            Route::get('create', ['as' => 'create/category', 'uses' => 'CategoriesController@getCreate']);
            Route::post('create', 'CategoriesController@postCreate');
            Route::get('{categoryId}/edit', ['as' => 'update/category', 'uses' => 'CategoriesController@getEdit']);
            Route::post('{categoryId}/edit', 'CategoriesController@postEdit');
            Route::get('{categoryId}/delete', ['as' => 'delete/category', 'uses' => 'CategoriesController@getDelete']);
            Route::get('{categoryId}/view', ['as' => 'view/category', 'uses' => 'CategoriesController@getView']);
            Route::get('/', ['as' => 'categories', 'uses' => 'CategoriesController@getIndex']);
        });


        # Depreciations
        Route::group(['prefix' => 'depreciations'], function () {
            Route::get('/', ['as' => 'depreciations', 'uses' => 'DepreciationsController@getIndex']);
            Route::get('create', ['as' => 'create/depreciations', 'uses' => 'DepreciationsController@getCreate']);
            Route::post('create', 'DepreciationsController@postCreate');
            Route::get('{depreciationId}/edit', ['as' => 'update/depreciations', 'uses' => 'DepreciationsController@getEdit']);
            Route::post('{depreciationId}/edit', 'DepreciationsController@postEdit');
            Route::get('{depreciationId}/delete', ['as' => 'delete/depreciations', 'uses' => 'DepreciationsController@getDelete']);
        });

        # Locations
        Route::group(['prefix' => 'locations'], function () {
            Route::get('/', ['as' => 'locations', 'uses' => 'LocationsController@getIndex']);
            Route::get('create', ['as' => 'create/location', 'uses' => 'LocationsController@getCreate']);
            Route::post('create', 'LocationsController@postCreate');
            Route::get('{locationId}/edit', ['as' => 'update/location', 'uses' => 'LocationsController@getEdit']);
            Route::post('{locationId}/edit', 'LocationsController@postEdit');
            Route::get('{locationId}/delete', ['as' => 'delete/location', 'uses' => 'LocationsController@getDelete']);
        });

        # Status Labels
        Route::group(['prefix' => 'statuslabels'], function () {
            Route::get('/', ['as' => 'statuslabels', 'uses' => 'StatuslabelsController@getIndex']);
            Route::get('create', ['as' => 'create/statuslabel', 'uses' => 'StatuslabelsController@getCreate']);
            Route::post('create', 'StatuslabelsController@postCreate');
            Route::get('{statuslabelId}/edit', ['as' => 'update/statuslabel', 'uses' => 'StatuslabelsController@getEdit']);
            Route::post('{statuslabelId}/edit', 'StatuslabelsController@postEdit');
            Route::get('{statuslabelId}/delete', ['as' => 'delete/statuslabel', 'uses' => 'StatuslabelsController@getDelete']);
        });


    });



    # User Management
    Route::group(['prefix' => 'users'], function () {

        Route::get('create', ['as' => 'create/user', 'uses' => 'UsersController@getCreate']);
        Route::post('create', 'UsersController@postCreate');
        Route::get('import', ['as' => 'import/user', 'uses' => 'UsersController@getImport']);
        Route::post('import', 'UsersController@postImport');
        Route::get('{userId}/edit', ['as' => 'update/user', 'uses' => 'UsersController@getEdit']);
        Route::post('{userId}/edit', 'UsersController@postEdit');
        Route::get('{userId}/clone', ['as' => 'clone/user', 'uses' => 'UsersController@getClone']);
        Route::post('{userId}/clone', 'UsersController@postCreate');
        Route::get('{userId}/delete', ['as' => 'delete/user', 'uses' => 'UsersController@getDelete']);
        Route::get('{userId}/restore', ['as' => 'restore/user', 'uses' => 'UsersController@getRestore']);
        Route::get('{userId}/view', ['as' => 'view/user', 'uses' => 'UsersController@getView']);
        Route::get('{userId}/unsuspend', ['as' => 'unsuspend/user', 'uses' => 'UsersController@getUnsuspend']);
		Route::get('/', ['as' => 'users', 'uses' => 'UsersController@getIndex']);

    });

    # Group Management
    Route::group(['prefix' => 'groups'], function () {
        Route::get('/', ['as' => 'groups', 'uses' => 'GroupsController@getIndex']);
        Route::get('create', ['as' => 'create/group', 'uses' => 'GroupsController@getCreate']);
        Route::post('create', 'GroupsController@postCreate');
        Route::get('{groupId}/edit', ['as' => 'update/group', 'uses' => 'GroupsController@getEdit']);
        Route::post('{groupId}/edit', 'GroupsController@postEdit');
        Route::get('{groupId}/delete', ['as' => 'delete/group', 'uses' => 'GroupsController@getDelete']);
        Route::get('{groupId}/restore', ['as' => 'restore/group', 'uses' => 'GroupsController@getRestore']);
        Route::get('{groupId}/view', ['as' => 'view/group', 'uses' => 'GroupsController@getView']);
    });

    # Dashboard
    Route::get('/', ['as' => 'admin', 'uses' => 'DashboardController@getIndex']);

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
    Route::get('reports/improvements', array('as' => 'reports/improvements', 'uses' => 'ReportsController@getImprovementsReport'));
    Route::get('reports/export/improvements', array('as' => 'reports/export/improvements', 'uses' => 'ReportsController@exportImprovementsReport'));
    Route::get('reports/licenses', array('as' => 'reports/licenses', 'uses' => 'ReportsController@getLicenseReport'));
    Route::get('reports/export/licenses', array('as' => 'reports/export/licenses', 'uses' => 'ReportsController@exportLicenseReport'));
    Route::get('reports/assets', array('as' => 'reports/assets', 'uses' => 'ReportsController@getAssetsReport'));
    Route::get('reports/export/assets', array('as' => 'reports/export/assets', 'uses' => 'ReportsController@exportAssetReport'));
    Route::get('reports/custom', array('as' => 'reports/custom', 'uses' => 'ReportsController@getCustomReport'));
    Route::post('reports/custom', 'ReportsController@postCustom');

     Route::get('reports/activity', array('as' => 'reports/activity', 'uses' => 'ReportsController@getActivityReport'));
});



Route::get('/', array('as' => 'home', 'before' => 'admin-auth', 'uses' => 'Controllers\Admin\DashboardController@getIndex'));



