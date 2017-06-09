<?php


Route::group(['middleware' => 'auth'], function () {
    /*
    * Companies
    */
    Route::resource('companies', 'CompaniesController', [
        'parameters' => ['company' => 'company_id']
    ]);

    /*
    * Categories
    */
    Route::resource('categories', 'CategoriesController', [
        'parameters' => ['category' => 'category_id']
    ]);

    /*
    * Locations
    */
    Route::resource('locations', 'LocationsController', [
        'parameters' => ['location' => 'location_id']
    ]);

    /*
    * Manufacturers
    */
    Route::resource('manufacturers', 'ManufacturersController', [
        'parameters' => ['manufacturer' => 'manufacturers_id']
    ]);

    /*
    * Suppliers
    */
    Route::resource('suppliers', 'SuppliersController', [
        'parameters' => ['supplier' => 'supplier_id']
    ]);

    /*
    * Depreciations
     */
     Route::resource('depreciations', 'DepreciationsController', [
         'parameters' => ['depreciation' => 'depreciation_id']
     ]);

     /*
     * Status Labels
      */
      Route::resource('statuslabels', 'StatuslabelsController', [
          'parameters' => ['statuslabel' => 'statuslabel_id']
      ]);


    /*
    * Status Labels
    */
    Route::resource('components', 'ComponentsController', [
        'parameters' => ['component' => 'component_id']
    ]);

    /*
    * Departments
    */
    Route::resource('departments', 'DepartmentsController', [
        'parameters' => ['department' => 'department_id']
    ]);


});



/*
|--------------------------------------------------------------------------
| Log Routes
|--------------------------------------------------------------------------
|
| Register all the admin routes.
|
*/

Route::group(['middleware' => 'auth'], function () {

    Route::get(
        'display-sig/{filename}',
        [
            'as' => 'log.signature.view',
            'uses' => 'ActionlogController@displaySig' ]
    );


});



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Register all the admin routes.
|
*/

Route::group([ 'prefix' => 'admin','middleware' => ['auth']], function () {

    Route::get('requests',
        // foreach( CheckoutRequest::with('user')->get() as $requestedItem) {
        //     echo $requestedItem->user->username . ' requested ' . $requestedItem->requestedItem->name;
            [
            'as' => 'requests',
            'middleware' => 'authorize:admin',
            'uses' => 'ViewAssetsController@getRequestedIndex'
            ]);


    # Admin Settings Routes (for categories, maufactureres, etc)
    Route::group([ 'prefix' => 'settings', 'middleware'=>'authorize:superuser'], function () {

        # Settings
        Route::group([ 'prefix' => 'app' ], function () {

            Route::get('api', [ 'as' => 'settings.api', 'uses' => 'SettingsController@api' ]);
            Route::post('purge', ['as' => 'purge', 'uses' => 'SettingsController@postPurge']);
            Route::get('edit', [ 'as' => 'edit/settings', 'uses' => 'SettingsController@getEdit' ]);
            Route::post('edit', 'SettingsController@postEdit');

            Route::get('ldaptest', [
                'as' => 'settings/ldaptest',
                'uses' => 'SettingsController@getLdapTest'
            ]);

            Route::get('/', [ 'as' => 'app', 'uses' => 'SettingsController@getIndex' ]);
        });



        # Settings
        Route::group([ 'prefix' => 'backups', 'middleware' => 'auth' ], function () {


            Route::get('download/{filename}', [
                'as' => 'settings/download-file',
                'uses' => 'SettingsController@downloadFile' ]);

            Route::delete('delete/{filename}', [
                'as' => 'settings/delete-file',
                'uses' => 'SettingsController@deleteFile' ]);

            Route::post('/', [
                'as' => 'settings/backups',
                'uses' => 'SettingsController@postBackups'
            ]);


            Route::get('/', [ 'as' => 'settings/backups', 'uses' => 'SettingsController@getBackups' ]);
        });

    });


    # Dashboard
    Route::get('/', [ 'as' => 'admin', 'uses' => 'DashboardController@getIndex' ]);

});


Route::resource('groups', 'GroupsController', [
    'middleware' => ['auth'],
    'parameters' => ['group' => 'group_id']
]);




/*
|--------------------------------------------------------------------------
| Account Routes
|--------------------------------------------------------------------------
|
|
|
*/
Route::group([ 'prefix' => 'account', 'middleware' => ['auth']], function () {

    # Profile
    Route::get('profile', [ 'as' => 'profile', 'uses' => 'ProfileController@getIndex' ]);
    Route::post('profile', 'ProfileController@postIndex');
    Route::get('api', [ 'as' => 'user.api', 'uses' => 'ProfileController@api' ]);

    # View Assets
    Route::get('view-assets', [ 'as' => 'view-assets', 'uses' => 'ViewAssetsController@getIndex' ]);

    # Accept Asset
    Route::get(
        'accept-asset/{logID}',
        [ 'as' => 'account/accept-assets', 'uses' => 'ViewAssetsController@getAcceptAsset' ]
    );
    Route::post(
        'accept-asset/{logID}',
        [ 'as' => 'account/asset-accepted', 'uses' => 'ViewAssetsController@postAcceptAsset' ]
    );

    # Profile
    Route::get(
        'requestable-assets',
        [ 'as' => 'requestable-assets', 'uses' => 'ViewAssetsController@getRequestableIndex' ]
    );
    Route::get(
        'request-asset/{assetId}',
        [ 'as' => 'account/request-asset', 'uses' => 'ViewAssetsController@getRequestAsset' ]
    );

    Route::post(
        'request/{itemType}/{itemId}',
        [ 'as' => 'account/request-item', 'uses' => 'ViewAssetsController@getRequestItem']
    );

    # Account Dashboard
    Route::get('/', [ 'as' => 'account', 'uses' => 'ViewAssetsController@getIndex' ]);

});


Route::group(['middleware' => ['auth']], function () {

    Route::get(
        'reports/depreciation',
        [ 'as' => 'reports/depreciation', 'uses' => 'ReportsController@getDeprecationReport' ]
    );
    Route::get(
        'reports/export/depreciation',
        [ 'as' => 'reports/export/depreciation', 'uses' => 'ReportsController@exportDeprecationReport' ]
    );
    Route::get(
        'reports/asset_maintenances',
        [ 'as' => 'reports/asset_maintenances', 'uses' => 'ReportsController@getAssetMaintenancesReport' ]
    );
    Route::get(
        'reports/export/asset_maintenances',
        [
            'as'   => 'reports/export/asset_maintenances',
            'uses' => 'ReportsController@exportAssetMaintenancesReport'
        ]
    );
    Route::get(
        'reports/licenses',
        [ 'as' => 'reports/licenses', 'uses' => 'ReportsController@getLicenseReport' ]
    );
    Route::get(
        'reports/export/licenses',
        [ 'as' => 'reports/export/licenses', 'uses' => 'ReportsController@exportLicenseReport' ]
    );
    Route::get('reports/assets', [ 'as' => 'reports/assets', 'uses' => 'ReportsController@getAssetsReport' ]);
    Route::get(
        'reports/export/assets',
        [ 'as' => 'reports/export/assets', 'uses' => 'ReportsController@exportAssetReport' ]
    );
    Route::get('reports/accessories', [ 'as' => 'reports/accessories', 'uses' => 'ReportsController@getAccessoryReport' ]);
    Route::get(
        'reports/export/accessories',
        [ 'as' => 'reports/export/accessories', 'uses' => 'ReportsController@exportAccessoryReport' ]
    );
    Route::get('reports/custom', [ 'as' => 'reports/custom', 'uses' => 'ReportsController@getCustomReport' ]);
    Route::post('reports/custom', 'ReportsController@postCustom');

    Route::get(
        'reports/activity',
        [ 'as' => 'reports/activity', 'uses' => 'ReportsController@getActivityReport' ]
    );


    Route::get(
        'reports/unaccepted_assets',
        [ 'as' => 'reports/unaccepted_assets', 'uses' => 'ReportsController@getAssetAcceptanceReport' ]
    );
    Route::get(
        'reports/export/unaccepted_assets',
        [ 'as' => 'reports/export/unaccepted_assets', 'uses' => 'ReportsController@exportAssetAcceptanceReport' ]
    );
});

Route::get(
    'auth/signin',
    ['uses' => 'Auth\LoginController@legacyAuthRedirect' ]
);




/*
|--------------------------------------------------------------------------
| Setup Routes
|--------------------------------------------------------------------------
|
|
|
*/
Route::group([ 'prefix' => 'setup', 'middleware' => 'web'], function () {
    Route::get(
        'user',
        [
        'as'  => 'setup.user',
        'uses' => 'SettingsController@getSetupUser' ]
    );

    Route::post(
        'user',
        [
        'as'  => 'setup.user.save',
        'uses' => 'SettingsController@postSaveFirstAdmin' ]
    );


    Route::get(
        'migrate',
        [
        'as'  => 'setup.migrate',
        'uses' => 'SettingsController@getSetupMigrate' ]
    );

    Route::get(
        'done',
        [
        'as'  => 'setup.done',
        'uses' => 'SettingsController@getSetupDone' ]
    );

    Route::get(
        'mailtest',
        [
        'as'  => 'setup.mailtest',
        'uses' => 'SettingsController@ajaxTestEmail' ]
    );


    Route::get(
        '/',
        [
        'as'  => 'setup',
        'uses' => 'SettingsController@getSetupIndex' ]
    );

});

Route::get(
    'two-factor-enroll',
    [
        'as' => 'two-factor-enroll',
        'middleware' => ['web'],
        'uses' => 'Auth\LoginController@getTwoFactorEnroll' ]
);

Route::get(
    'two-factor',
    [
        'as' => 'two-factor',
        'middleware' => ['web'],
        'uses' => 'Auth\LoginController@getTwoFactorAuth' ]
);

Route::post(
    'two-factor',
    [
        'as' => 'two-factor',
        'middleware' => ['web'],
        'uses' => 'Auth\LoginController@postTwoFactorAuth' ]
);

Route::get(
    '/',
    [
    'as' => 'home',
    'middleware' => ['auth'],
    'uses' => 'DashboardController@getIndex' ]
);



Route::group(['middleware' => 'web'], function () {
    //Route::auth();
    Route::get(
        'login',
        [
            'as' => 'login',
            'middleware' => ['web'],
            'uses' => 'Auth\LoginController@showLoginForm' ]
    );

    Route::post(
        'login',
        [
            'as' => 'login',
            'middleware' => ['web'],
            'uses' => 'Auth\LoginController@login' ]
    );

    Route::get(
        'logout',
        [
            'as' => 'logout',
            'uses' => 'Auth\LoginController@logout' ]
    );

});




