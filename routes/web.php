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

    Route::group([ 'prefix' => 'manufacturers', 'middleware' => ['auth'] ], function () {

        Route::get('{manufacturers_id}/restore', [ 'as' => 'restore/manufacturer', 'uses' => 'ManufacturersController@restore']);
    });

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
|
|--------------------------------------------------------------------------
| Re-Usable Modal Dialog routes.
|--------------------------------------------------------------------------
|
| Routes for various modal dialogs to interstitially create various things
| 
*/

Route::group(['middleware' => 'auth','prefix' => 'modals'], function () {
    Route::get('location',['as' => 'modal.location','uses' => 'ModalController@location']);
    Route::get('category',['as' => 'modal.category','uses' => 'ModalController@category']);
    Route::get('manufacturer',['as' => 'modal.manufacturer','uses' => 'ModalController@manufacturer']);
    Route::get('model',['as' => 'modal.model','uses' => 'ModalController@model']);
    Route::get('statuslabel',['as' => 'modal.statuslabel','uses' => 'ModalController@statuslabel']);
    Route::get('supplier',['as' => 'modal.supplier','uses' => 'ModalController@supplier']);
    Route::get('user',['as' => 'modal.user','uses' => 'ModalController@user']);
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



Route::group([ 'prefix' => 'admin','middleware' => ['auth', 'authorize:superuser']], function () {

    Route::get('settings', ['as' => 'settings.general.index','uses' => 'SettingsController@getSettings' ]);
    Route::post('settings', ['as' => 'settings.general.save','uses' => 'SettingsController@postSettings' ]);


    Route::get('branding', ['as' => 'settings.branding.index','uses' => 'SettingsController@getBranding' ]);
    Route::post('branding', ['as' => 'settings.branding.save','uses' => 'SettingsController@postBranding' ]);

    Route::get('security', ['as' => 'settings.security.index','uses' => 'SettingsController@getSecurity' ]);
    Route::post('security', ['as' => 'settings.security.save','uses' => 'SettingsController@postSecurity' ]);

    Route::get('groups', ['as' => 'settings.groups.index','uses' => 'GroupsController@index' ]);

    Route::get('localization', ['as' => 'settings.localization.index','uses' => 'SettingsController@getLocalization' ]);
    Route::post('localization', ['as' => 'settings.localization.save','uses' => 'SettingsController@postLocalization' ]);

    Route::get('notifications', ['as' => 'settings.alerts.index','uses' => 'SettingsController@getAlerts' ]);
    Route::post('notifications', ['as' => 'settings.alerts.save','uses' => 'SettingsController@postAlerts' ]);

    Route::get('slack', ['as' => 'settings.slack.index','uses' => 'SettingsController@getSlack' ]);
    Route::post('slack', ['as' => 'settings.slack.save','uses' => 'SettingsController@postSlack' ]);

    Route::get('asset_tags', ['as' => 'settings.asset_tags.index','uses' => 'SettingsController@getAssetTags' ]);
    Route::post('asset_tags', ['as' => 'settings.asset_tags.save','uses' => 'SettingsController@postAssetTags' ]);

    Route::get('barcodes', ['as' => 'settings.barcodes.index','uses' => 'SettingsController@getBarcodes' ]);
    Route::post('barcodes', ['as' => 'settings.barcodes.save','uses' => 'SettingsController@postBarcodes' ]);

    Route::get('labels', ['as' => 'settings.labels.index','uses' => 'SettingsController@getLabels' ]);
    Route::post('labels', ['as' => 'settings.labels.save','uses' => 'SettingsController@postLabels' ]);

    Route::get('ldap', ['as' => 'settings.ldap.index','uses' => 'SettingsController@getLdapSettings' ]);
    Route::post('ldap', ['as' => 'settings.ldap.save','uses' => 'SettingsController@postLdapSettings' ]);

    Route::get('phpinfo', ['as' => 'settings.phpinfo.index','uses' => 'SettingsController@getPhpInfo' ]);


    Route::get('oauth', [ 'as' => 'settings.oauth.index', 'uses' => 'SettingsController@api' ]);

    Route::get('purge', ['as' => 'settings.purge.index', 'uses' => 'SettingsController@getPurge']);
    Route::post('purge', ['as' => 'settings.purge.save', 'uses' => 'SettingsController@postPurge']);

    # Backups
    Route::group([ 'prefix' => 'backups', 'middleware' => 'auth' ], function () {


        Route::get('download/{filename}', [
            'as' => 'settings.backups.download',
            'uses' => 'SettingsController@downloadFile' ]);

        Route::delete('delete/{filename}', [
            'as' => 'settings.backups.destroy',
            'uses' => 'SettingsController@deleteFile' ]);

        Route::post('/', [
            'as' => 'settings.backups.create',
            'uses' => 'SettingsController@postBackups'
        ]);

        Route::get('/', [ 'as' => 'settings.backups.index', 'uses' => 'SettingsController@getBackups' ]);

    });



    Route::resource('groups', 'GroupsController', [
        'middleware' => ['auth'],
        'parameters' => ['group' => 'group_id']
    ]);

    Route::get('/', ['as' => 'settings.index', 'uses' => 'SettingsController@index' ]);


});




/*
|--------------------------------------------------------------------------
| Importer Routes
|--------------------------------------------------------------------------
|
|
|
*/
Route::group([ 'prefix' => 'import', 'middleware' => ['auth']], function () {
        Route::get('/', [
                'as' => 'imports.index',
                'uses' => 'ImportsController@index'
        ]);
});


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

    Route::get('menu', [ 'as' => 'account.menuprefs', 'uses' => 'ProfileController@getMenuState' ]);

    Route::get('password', [ 'as' => 'account.password.index', 'uses' => 'ProfileController@password' ]);
    Route::post('password', [ 'uses' => 'ProfileController@passwordSave' ]);

    Route::get('api', [ 'as' => 'user.api', 'uses' => 'ProfileController@api' ]);

    # View Assets
    Route::get('view-assets', [ 'as' => 'view-assets', 'uses' => 'ViewAssetsController@getIndex' ]);

    Route::get('requested', [ 'as' => 'account.requested', 'uses' => 'ViewAssetsController@getRequestedAssets' ]);

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

    Route::get('reports/audit', [
        'as' => 'reports.audit',
        'uses' => 'ReportsController@audit'
    ]);

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

    Route::get('reports/accessories', [ 'as' => 'reports/accessories', 'uses' => 'ReportsController@getAccessoryReport' ]);
    Route::get(
        'reports/export/accessories',
        [ 'as' => 'reports/export/accessories', 'uses' => 'ReportsController@exportAccessoryReport' ]
    );
    Route::get('reports/custom', [ 'as' => 'reports/custom', 'uses' => 'ReportsController@getCustomReport' ]);
    Route::post('reports/custom', 'ReportsController@postCustom');

    Route::get(
        'reports/activity',
        [ 'as' => 'reports.activity', 'uses' => 'ReportsController@getActivityReport' ]
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

Auth::routes();



