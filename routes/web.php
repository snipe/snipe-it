<?php

use App\Http\Controllers\Account;
use App\Http\Controllers\ActionlogController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\DepreciationsController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\ImportsController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\ManufacturersController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StatuslabelsController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\ViewAssetsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::group(['middleware' => 'auth'], function () {
    /*
    * Companies
    */
    Route::resource('companies', CompaniesController::class, [
        'parameters' => ['company' => 'company_id'],
    ]);

    /*
    * Categories
    */
    Route::resource('categories', CategoriesController::class, [
        'parameters' => ['category' => 'category_id'],
    ]);

    /*
    * Locations
    */
    Route::resource('locations', LocationsController::class, [
        'parameters' => ['location' => 'location_id'],
    ]);

    Route::get(
        'locations/{locationId}/printassigned',
        ['as' => 'locations.print_assigned', 'uses' => [LocationsController::class, 'print_assigned']]
    );

    Route::get(
        'locations/{locationId}/printallassigned',
        ['as' => 'locations.print_all_assigned', 'uses' => [LocationsController::class, 'print_all_assigned']]
    );

    /*
    * Manufacturers
    */

    Route::group(['prefix' => 'manufacturers', 'middleware' => ['auth']], function () {
        Route::get('{manufacturers_id}/restore', ['as' => 'restore/manufacturer', 'uses' => [ManufacturersController::class, 'restore']]);
    });

    Route::resource('manufacturers', ManufacturersController::class, [
        'parameters' => ['manufacturer' => 'manufacturers_id'],
    ]);

    /*
    * Suppliers
    */
    Route::resource('suppliers', SuppliersController::class, [
        'parameters' => ['supplier' => 'supplier_id'],
    ]);

    /*
    * Depreciations
     */
    Route::resource('depreciations', DepreciationsController::class, [
         'parameters' => ['depreciation' => 'depreciation_id'],
     ]);

    /*
    * Status Labels
     */
    Route::resource('statuslabels', StatuslabelsController::class, [
          'parameters' => ['statuslabel' => 'statuslabel_id'],
      ]);

    /*
    * Departments
    */
    Route::resource('departments', DepartmentsController::class, [
        'parameters' => ['department' => 'department_id'],
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

Route::group(['middleware' => 'auth', 'prefix' => 'modals'], function () {
    Route::get('{type}/{itemId?}', ['as' => 'modal.show', 'uses' => [ModalController::class, 'show']]);
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
            'uses' => [ActionlogController::class, 'displaySig'], ]
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

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'authorize:superuser']], function () {
    Route::get('settings', ['as' => 'settings.general.index', 'uses' => [SettingsController::class, 'getSettings']]);
    Route::post('settings', ['as' => 'settings.general.save', 'uses' => [SettingsController::class, 'postSettings']]);

    Route::get('branding', ['as' => 'settings.branding.index', 'uses' => [SettingsController::class, 'getBranding']]);
    Route::post('branding', ['as' => 'settings.branding.save', 'uses' => [SettingsController::class, 'postBranding']]);

    Route::get('security', ['as' => 'settings.security.index', 'uses' => [SettingsController::class, 'getSecurity']]);
    Route::post('security', ['as' => 'settings.security.save', 'uses' => [SettingsController::class, 'postSecurity']]);

    Route::get('groups', ['as' => 'settings.groups.index', 'uses' => [GroupsController::class, 'index']]);

    Route::get('localization', ['as' => 'settings.localization.index', 'uses' => [SettingsController::class, 'getLocalization']]);
    Route::post('localization', ['as' => 'settings.localization.save', 'uses' => [SettingsController::class, 'postLocalization']]);

    Route::get('notifications', ['as' => 'settings.alerts.index', 'uses' => [SettingsController::class, 'getAlerts']]);
    Route::post('notifications', ['as' => 'settings.alerts.save', 'uses' => [SettingsController::class, 'postAlerts']]);

    Route::get('slack', ['as' => 'settings.slack.index', 'uses' => [SettingsController::class, 'getSlack']]);
    Route::post('slack', ['as' => 'settings.slack.save', 'uses' => [SettingsController::class, 'postSlack']]);

    Route::get('asset_tags', ['as' => 'settings.asset_tags.index', 'uses' => [SettingsController::class, 'getAssetTags']]);
    Route::post('asset_tags', ['as' => 'settings.asset_tags.save', 'uses' => [SettingsController::class, 'postAssetTags']]);

    Route::get('barcodes', ['as' => 'settings.barcodes.index', 'uses' => [SettingsController::class, 'getBarcodes']]);
    Route::post('barcodes', ['as' => 'settings.barcodes.save', 'uses' => [SettingsController::class, 'postBarcodes']]);

    Route::get('labels', ['as' => 'settings.labels.index', 'uses' => [SettingsController::class, 'getLabels']]);
    Route::post('labels', ['as' => 'settings.labels.save', 'uses' => [SettingsController::class, 'postLabels']]);

    Route::get('ldap', ['as' => 'settings.ldap.index', 'uses' => [SettingsController::class, 'getLdapSettings']]);
    Route::post('ldap', ['as' => 'settings.ldap.save', 'uses' => [SettingsController::class, 'postLdapSettings']]);

    Route::get('phpinfo', ['as' => 'settings.phpinfo.index', 'uses' => [SettingsController::class, 'getPhpInfo']]);

    Route::get('oauth', ['as' => 'settings.oauth.index', 'uses' => [SettingsController::class, 'api']]);

    Route::get('purge', ['as' => 'settings.purge.index', 'uses' => [SettingsController::class, 'getPurge']]);
    Route::post('purge', ['as' => 'settings.purge.save', 'uses' => [SettingsController::class, 'postPurge']]);

    Route::get('login-attempts', ['as' => 'settings.logins.index', 'uses' => [SettingsController::class, 'getLoginAttempts']]);

    // Backups
    Route::group(['prefix' => 'backups', 'middleware' => 'auth'], function () {
        Route::get('download/{filename}', [
            'as' => 'settings.backups.download',
            'uses' => [SettingsController::class, 'downloadFile'], ]);

        Route::delete('delete/{filename}', [
            'as' => 'settings.backups.destroy',
            'uses' => [SettingsController::class, 'deleteFile'], ]);

        Route::post('/', [
            'as' => 'settings.backups.create',
            'uses' => [SettingsController::class, 'postBackups'],
        ]);

        Route::get('/', ['as' => 'settings.backups.index', 'uses' => [SettingsController::class, 'getBackups']]);
    });

    Route::resource('groups', GroupsController::class, [
        'middleware' => ['auth'],
        'parameters' => ['group' => 'group_id'],
    ]);

    Route::get('/', ['as' => 'settings.index', 'uses' => [SettingsController::class, 'index']]);
});

/*
|--------------------------------------------------------------------------
| Importer Routes
|--------------------------------------------------------------------------
|
|
|
*/
Route::group(['prefix' => 'import', 'middleware' => ['auth']], function () {
    Route::get('/', [
                'as' => 'imports.index',
                'uses' => [ImportsController::class, 'index'],
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
Route::group(['prefix' => 'account', 'middleware' => ['auth']], function () {

    // Profile
    Route::get('profile', ['as' => 'profile', 'uses' => [ProfileController::class, 'getIndex']]);
    Route::post('profile', [ProfileController::class, 'postIndex']);

    Route::get('menu', ['as' => 'account.menuprefs', 'uses' => [ProfileController::class, 'getMenuState']]);

    Route::get('password', ['as' => 'account.password.index', 'uses' => [ProfileController::class, 'password']]);
    Route::post('password', ['uses' => [ProfileController::class, 'passwordSave']]);

    Route::get('api', ['as' => 'user.api', 'uses' => [ProfileController::class, 'api']]);

    // View Assets
    Route::get('view-assets', ['as' => 'view-assets', 'uses' => [ViewAssetsController::class, 'getIndex']]);

    Route::get('requested', ['as' => 'account.requested', 'uses' => [ViewAssetsController::class, 'getRequestedAssets']]);

    // Accept Asset
    Route::get(
        'accept-asset/{logID}',
        ['as' => 'account/accept-assets', 'uses' => [ViewAssetsController::class, 'getAcceptAsset']]
    );

    // Profile
    Route::get(
        'requestable-assets',
        ['as' => 'requestable-assets', 'uses' => [ViewAssetsController::class, 'getRequestableIndex']]
    );
    Route::get(
        'request-asset/{assetId}',
        ['as' => 'account/request-asset', 'uses' => [ViewAssetsController::class, 'getRequestAsset']]
    );

    Route::post(
        'request/{itemType}/{itemId}',
        ['as' => 'account/request-item', 'uses' => [ViewAssetsController::class, 'getRequestItem']]
    );

    // Account Dashboard
    Route::get('/', ['as' => 'account', 'uses' => [ViewAssetsController::class, 'getIndex']]);

    Route::get('accept', [Account\AcceptanceController::class, 'index'])
        ->name('account.accept');

    Route::get('accept/{id}', [Account\AcceptanceController::class, 'create'])
        ->name('account.accept.item');

    Route::post('accept/{id}', [Account\AcceptanceController::class, 'store']);
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('reports/audit', [
        'as' => 'reports.audit',
        'uses' => [ReportsController::class, 'audit'],
    ]);

    Route::get(
        'reports/depreciation',
        ['as' => 'reports/depreciation', 'uses' => [ReportsController::class, 'getDeprecationReport']]
    );
    Route::get(
        'reports/export/depreciation',
        ['as' => 'reports/export/depreciation', 'uses' => [ReportsController::class, 'exportDeprecationReport']]
    );
    Route::get(
        'reports/asset_maintenances',
        ['as' => 'reports/asset_maintenances', 'uses' => [ReportsController::class, 'getAssetMaintenancesReport']]
    );
    Route::get(
        'reports/export/asset_maintenances',
        [
            'as'   => 'reports/export/asset_maintenances',
            'uses' => [ReportsController::class, 'exportAssetMaintenancesReport'],
        ]
    );
    Route::get(
        'reports/licenses',
        ['as' => 'reports/licenses', 'uses' => [ReportsController::class, 'getLicenseReport']]
    );
    Route::get(
        'reports/export/licenses',
        ['as' => 'reports/export/licenses', 'uses' => [ReportsController::class, 'exportLicenseReport']]
    );

    Route::get('reports/accessories', ['as' => 'reports/accessories', 'uses' => [ReportsController::class, 'getAccessoryReport']]);
    Route::get(
        'reports/export/accessories',
        ['as' => 'reports/export/accessories', 'uses' => [ReportsController::class, 'exportAccessoryReport']]
    );
    Route::get('reports/custom', ['as' => 'reports/custom', 'uses' => [ReportsController::class, 'getCustomReport']]);
    Route::post('reports/custom', [ReportsController::class, 'postCustom']);

    Route::get(
        'reports/activity',
        ['as' => 'reports.activity', 'uses' => [ReportsController::class, 'getActivityReport']]
    );

    Route::post('reports/activity', [ReportsController::class, 'postActivityReport']);

    Route::get(
        'reports/unaccepted_assets',
        ['as' => 'reports/unaccepted_assets', 'uses' => [ReportsController::class, 'getAssetAcceptanceReport']]
    );
    Route::get(
        'reports/export/unaccepted_assets',
        ['as' => 'reports/export/unaccepted_assets', 'uses' => [ReportsController::class, 'exportAssetAcceptanceReport']]
    );
});

Route::get(
    'auth/signin',
    ['uses' => [Auth\LoginController::class, 'legacyAuthRedirect']]
);

/*
|--------------------------------------------------------------------------
| Setup Routes
|--------------------------------------------------------------------------
|
|
|
*/
Route::group(['prefix' => 'setup', 'middleware' => 'web'], function () {
    Route::get(
        'user',
        [
        'as'  => 'setup.user',
        'uses' => [SettingsController::class, 'getSetupUser'], ]
    );

    Route::post(
        'user',
        [
        'as'  => 'setup.user.save',
        'uses' => [SettingsController::class, 'postSaveFirstAdmin'], ]
    );

    Route::get(
        'migrate',
        [
        'as'  => 'setup.migrate',
        'uses' => [SettingsController::class, 'getSetupMigrate'], ]
    );

    Route::get(
        'done',
        [
        'as'  => 'setup.done',
        'uses' => [SettingsController::class, 'getSetupDone'], ]
    );

    Route::get(
        'mailtest',
        [
        'as'  => 'setup.mailtest',
        'uses' => [SettingsController::class, 'ajaxTestEmail'], ]
    );

    Route::get(
        '/',
        [
        'as'  => 'setup',
        'uses' => [SettingsController::class, 'getSetupIndex'], ]
    );
});

Route::get(
    'two-factor-enroll',
    [
        'as' => 'two-factor-enroll',
        'middleware' => ['web'],
        'uses' => [Auth\LoginController::class, 'getTwoFactorEnroll'], ]
);

Route::get(
    'two-factor',
    [
        'as' => 'two-factor',
        'middleware' => ['web'],
        'uses' => [Auth\LoginController::class, 'getTwoFactorAuth'], ]
);

Route::post(
    'two-factor',
    [
        'as' => 'two-factor',
        'middleware' => ['web'],
        'uses' => [Auth\LoginController::class, 'postTwoFactorAuth'], ]
);



Route::group(['middleware' => 'web'], function () {
    Route::get(
        'login',
        [
            'as' => 'login',
            'middleware' => ['web'],
            'uses' => [Auth\LoginController::class, 'showLoginForm'], ]
    );

    Route::post(
        'login',
        [
            'as' => 'login',
            'middleware' => ['web'],
            'uses' => [Auth\LoginController::class, 'login'], ]
    );

    Route::get(
        'logout',
        [
            'as' => 'logout',
            'uses' => [Auth\LoginController::class, 'logout'], ]
    );
});

//Auth::routes();

Route::get(
    '/health', 
    [
    'as' => 'health', 
    'uses' => [HealthController::class, 'get'],]
);

Route::get(
    '/',
    [
    'as' => 'home',
    'middleware' => ['auth'],
    'uses' => [DashboardController::class, 'index'], ]
);
