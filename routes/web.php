<?php
use App\Models\CheckoutRequest;
use App\Models\Location;
use App\Models\Statuslabel;




/*
* Custom Fields Routes
 */
Route::resource('fields', 'CustomFieldsController', [
    'parameters' => ['customfield' => 'field_id', 'fieldset' => 'fieldset_id']
]);

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
            'middleware' => 'authorize:assets.view',
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

Route::group([ 'prefix' => 'admin','middleware' => ['web','auth']], function () {

    Route::get('requests',
        // foreach( CheckoutRequest::with('user')->get() as $requestedItem) {
        //     echo $requestedItem->user->username . ' requested ' . $requestedItem->requestedItem->name;
            [
            'as' => 'requests',
            'middleware' => 'authorize:admin',
            'uses' => 'ViewAssetsController@getRequestedIndex'
            ]);






    # Components
    Route::group([ 'prefix' => 'components', 'middleware'=>'authorize:components.view'  ], function () {

        Route::get('create', [ 'as' => 'create/component', 'middleware'=>'authorize:components.create','uses' => 'ComponentsController@getCreate' ]);
        Route::post('create', [ 'as' => 'create/component', 'middleware'=>'authorize:components.create','uses' => 'ComponentsController@postCreate' ]);
        Route::get(
            '{componentID}/edit',
            [ 'as' => 'update/component', 'middleware'=>'authorize:components.edit','uses' => 'ComponentsController@getEdit' ]
        );
        Route::post(
            '{componentID}/edit',
            [ 'as' => 'update/component', 'middleware'=>'authorize:components.edit','uses' => 'ComponentsController@postEdit' ]
        );
        Route::get(
            '{componentID}/delete',
            [ 'as' => 'delete/component', 'middleware'=>'authorize:components.delete','uses' => 'ComponentsController@getDelete' ]
        );
        Route::get(
            '{componentID}/view',
            [ 'as' => 'view/component', 'middleware'=>'authorize:components.view','uses' => 'ComponentsController@getView' ]
        );
        Route::get(
            '{componentID}/checkout',
            [ 'as' => 'checkout/component', 'middleware'=>'authorize:components.checkout','uses' => 'ComponentsController@getCheckout' ]
        );
        Route::post(
            '{componentID}/checkout',
            [ 'as' => 'checkout/component', 'middleware'=>'authorize:components.checkout','uses' => 'ComponentsController@postCheckout' ]
        );
        Route::post('bulk', [ 'as' => 'component/bulk-form', 'middleware'=>'authorize:components.checkout','uses' => 'ComponentsController@postBulk' ]);
        Route::post('bulksave', [ 'as' => 'component/bulk-save', 'middleware'=>'authorize:components.edit','uses' => 'ComponentsController@postBulkSave' ]);
        Route::get('/', [ 'as' => 'components', 'middleware'=>'authorize:components.view','uses' => 'ComponentsController@getIndex' ]);
    });

    # Admin Settings Routes (for categories, maufactureres, etc)
    Route::group([ 'prefix' => 'settings', 'middleware'=>'authorize:superuser'], function () {



        # Settings
        Route::group([ 'prefix' => 'app' ], function () {

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

            Route::get('delete/{filename}', [
                'as' => 'settings/delete-file',
                'uses' => 'SettingsController@deleteFile' ]);

            Route::post('/', [
                'as' => 'settings/backups',
                'uses' => 'SettingsController@postBackups'
            ]);


            Route::get('/', [ 'as' => 'settings/backups', 'uses' => 'SettingsController@getBackups' ]);
        });




        # Manufacturers
        Route::group([ 'prefix' => 'manufacturers' ], function () {

            Route::get('/', [ 'as' => 'manufacturers', 'uses' => 'ManufacturersController@getIndex' ]);
            Route::get(
                'create',
                [ 'as' => 'create/manufacturer', 'uses' => 'ManufacturersController@getCreate' ]
            );
            Route::post('create', 'ManufacturersController@postCreate');
            Route::get(
                '{manufacturerId}/edit',
                [ 'as' => 'update/manufacturer', 'uses' => 'ManufacturersController@getEdit' ]
            );
            Route::post('{manufacturerId}/edit', 'ManufacturersController@postEdit');
            Route::get(
                '{manufacturerId}/delete',
                [ 'as' => 'delete/manufacturer', 'uses' => 'ManufacturersController@getDelete' ]
            );
            Route::get(
                '{manufacturerId}/view',
                [ 'as' => 'view/manufacturer', 'uses' => 'ManufacturersController@getView' ]
            );
        });

        # Suppliers
        Route::group([ 'prefix' => 'suppliers' ], function () {

            Route::get('/', [ 'as' => 'suppliers', 'uses' => 'SuppliersController@getIndex' ]);
            Route::get('create', [ 'as' => 'create/supplier', 'uses' => 'SuppliersController@getCreate' ]);
            Route::post('create', 'SuppliersController@postCreate');
            Route::get(
                '{supplierId}/edit',
                [ 'as' => 'update/supplier', 'uses' => 'SuppliersController@getEdit' ]
            );
            Route::post('{supplierId}/edit', 'SuppliersController@postEdit');
            Route::get(
                '{supplierId}/delete',
                [ 'as' => 'delete/supplier', 'uses' => 'SuppliersController@getDelete' ]
            );
            Route::get('{supplierId}/view', [ 'as' => 'view/supplier', 'uses' => 'SuppliersController@getView' ]);
        });



        # Depreciations
        Route::group([ 'prefix' => 'depreciations' ], function () {

            Route::get('/', [ 'as' => 'depreciations', 'uses' => 'DepreciationsController@getIndex' ]);
            Route::get(
                'create',
                [ 'as' => 'create/depreciations', 'uses' => 'DepreciationsController@getCreate' ]
            );
            Route::post('create', 'DepreciationsController@postCreate');
            Route::get(
                '{depreciationId}/edit',
                [ 'as' => 'update/depreciations', 'uses' => 'DepreciationsController@getEdit' ]
            );
            Route::post('{depreciationId}/edit', 'DepreciationsController@postEdit');
            Route::get(
                '{depreciationId}/delete',
                [ 'as' => 'delete/depreciations', 'uses' => 'DepreciationsController@getDelete' ]
            );
        });

        # Locations
        Route::group([ 'prefix' => 'locations' ], function () {

            Route::get('/', [ 'as' => 'locations', 'uses' => 'LocationsController@getIndex' ]);
            Route::get('create', [ 'as' => 'create/location', 'uses' => 'LocationsController@getCreate' ]);
            Route::post('create', 'LocationsController@postCreate');
            Route::get(
                '{locationId}/edit',
                [ 'as' => 'update/location', 'uses' => 'LocationsController@getEdit' ]
            );
            Route::post('{locationId}/edit', 'LocationsController@postEdit');
            Route::get('{locationId}/view', [ 'as' => 'view/location', 'uses' => 'LocationsController@getView' ]);
            Route::get(
                '{locationId}/delete',
                [ 'as' => 'delete/location', 'uses' => 'LocationsController@getDelete' ]
            );
        });

        # Status Labels
        Route::group([ 'prefix' => 'statuslabels' ], function () {

            Route::get('/', [ 'as' => 'statuslabels', 'uses' => 'StatuslabelsController@getIndex' ]);
            Route::get('create', [ 'as' => 'create/statuslabel', 'uses' => 'StatuslabelsController@getCreate' ]);
            Route::post('create', 'StatuslabelsController@postCreate');
            Route::get(
                '{statuslabelId}/edit',
                [ 'as' => 'update/statuslabel', 'uses' => 'StatuslabelsController@getEdit' ]
            );
            Route::post('{statuslabelId}/edit', 'StatuslabelsController@postEdit');
            Route::get(
                '{statuslabelId}/delete',
                [ 'as' => 'delete/statuslabel', 'uses' => 'StatuslabelsController@getDelete' ]
            );
        });

    });

    # Custom fields support
    Route::get('customfields/field/create',
        ['uses' =>'CustomFieldsController@createField',
        'as' => 'admin.custom_fields.create-field']
    );

    Route::get('customfields/fieldset/create',
        ['as' => 'admin.custom_fields.create-fieldset',
        'uses' => 'CustomFieldsController@create']
    );

    Route::post('customfields/field/create',
        ['uses' => 'CustomFieldsController@storeField',
        'as' => 'admin.custom_fields.store-field']
    );

    Route::post('customfields/field/{id}/associate',
        ['uses' => 'CustomFieldsController@associate',
    '    as' => 'admin.custom_fields.associate']
    );

    Route::get('customfields/fieldset/{fieldset_id}/{field_id}/disassociate',
        ['uses' => 'CustomFieldsController@deleteFieldFromFieldset',
        'as' => 'admin.custom_fields.disassociate']
    );

    Route::get('custom_fields/field/{id}/delete',
        ['uses' =>'CustomFieldsController@deleteField',
        'as' => 'admin.custom_fields.delete-field']
    );

    Route::get('customfields/fieldset/{id}/view',
        ['uses' =>'CustomFieldsController@getCustomFieldset',
        'as' => 'admin.custom_fields.show']
    );

    Route::get('customfields',
        ['uses' =>'CustomFieldsController@getIndex',
        'as' => 'admin.custom_fields.index']
    );


    # User Management
    Route::group([ 'prefix' => 'users', 'middleware' => ['web','auth','authorize:users.view']], function () {

        Route::get('ldap', ['as' => 'ldap/user', 'uses' => 'UsersController@getLDAP', 'middleware' => ['authorize:users.edit'] ]);
        Route::post('ldap', 'UsersController@postLDAP');

        Route::get('create', [ 'as' => 'create/user', 'uses' => 'UsersController@getCreate', 'middleware' => ['authorize:users.edit']  ]);
        Route::post('create', [ 'uses' => 'UsersController@postCreate', 'middleware' => ['authorize:users.edit']  ]);
        Route::get('import', [ 'as' => 'import/user', 'uses' => 'UsersController@getImport', 'middleware' => ['authorize:users.edit']  ]);
        Route::post('import', [ 'uses' => 'UsersController@postImport', 'middleware' => ['authorize:users.edit']  ]);
        Route::get('export', [ 'uses' => 'UsersController@getExportUserCsv', 'middleware' => ['authorize:users.view']  ]);
        Route::get('{userId}/edit', [ 'as' => 'update/user', 'uses' => 'UsersController@getEdit', 'middleware' => ['authorize:users.edit']  ]);
        Route::post('{userId}/edit', [ 'uses' => 'UsersController@postEdit', 'middleware' => ['authorize:users.edit']  ]);
        Route::get('{userId}/clone', [ 'as' => 'clone/user', 'uses' => 'UsersController@getClone', 'middleware' => ['authorize:users.edit']  ]);
        Route::post('{userId}/clone', [ 'uses' => 'UsersController@postCreate', 'middleware' => ['authorize:users.edit']  ]);
        Route::get('{userId}/delete', [ 'as' => 'delete/user', 'uses' => 'UsersController@getDelete', 'middleware' => ['authorize:users.edit']  ]);
        Route::get('{userId}/restore', [ 'as' => 'restore/user', 'uses' => 'UsersController@getRestore', 'middleware' => ['authorize:users.edit']  ]);
        Route::get('{userId}/view', [ 'as' => 'view/user', 'uses' => 'UsersController@getView' , 'middleware' => ['authorize:users.view'] ]);
        Route::get('{userId}/unsuspend', [ 'as' => 'unsuspend/user', 'uses' => 'UsersController@getUnsuspend', 'middleware' => ['authorize:users.edit'] ]);
        Route::get(
            '{userId}/deletefile/{fileId}',
            [ 'as' => 'delete/userfile', 'uses' => 'UsersController@getDeleteFile' ]
        );
        Route::get(
            '{userId}/showfile/{fileId}',
            [ 'as' => 'show/userfile', 'uses' => 'UsersController@displayFile' ]
        );

        Route::post(
            'bulkedit',
            [
                'as'   => 'users/bulkedit',
                'uses' => 'UsersController@postBulkEdit',
                'middleware' => ['authorize:users.edit'],
            ]
        );
        Route::post(
            'bulksave',
            [
                'as'   => 'users/bulksave',
                'uses' => 'UsersController@postBulkSave',
                'middleware' => ['authorize:users.edit'],
            ]
        );

        Route::get('/', [ 'as' => 'users', 'uses' => 'UsersController@getIndex' ]);

    });

    # Group Management
    Route::group([ 'prefix' => 'groups', 'middleware' => ['web','auth','authorize:superadmin'] ], function () {

        Route::get('/', [ 'as' => 'groups', 'uses' => 'GroupsController@getIndex' ]);
        Route::get('create', [ 'as' => 'create/group', 'uses' => 'GroupsController@getCreate' ]);
        Route::post('create', 'GroupsController@postCreate');
        Route::get('{groupId}/edit', [ 'as' => 'update/group', 'uses' => 'GroupsController@getEdit' ]);
        Route::post('{groupId}/edit', 'GroupsController@postEdit');
        Route::get('{groupId}/delete', [ 'as' => 'delete/group', 'uses' => 'GroupsController@getDelete' ]);
        Route::get('{groupId}/restore', [ 'as' => 'restore/group', 'uses' => 'GroupsController@getRestore' ]);
        Route::get('{groupId}/view', [ 'as' => 'view/group', 'uses' => 'GroupsController@getView' ]);
    });

    # Dashboard
    Route::get('/', [ 'as' => 'admin', 'uses' => 'DashboardController@getIndex' ]);

});

/*
|--------------------------------------------------------------------------
| Account Routes
|--------------------------------------------------------------------------
|
|
|
*/
Route::group([ 'prefix' => 'account', 'middleware' => ['web', 'auth']], function () {

    # Profile
    Route::get('profile', [ 'as' => 'profile', 'uses' => 'ProfileController@getIndex' ]);
    Route::post('profile', 'ProfileController@postIndex');

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


Route::group(['middleware' => ['web','auth','authorize:reports.view']], function () {

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
        'reports/activity/json',
        [ 'as' => 'api.activity.list', 'uses' => 'ReportsController@getActivityReportDataTable' ]
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
    'middleware' => ['web', 'auth'],
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

Route::get('home', function () {
    return redirect('/');
});
