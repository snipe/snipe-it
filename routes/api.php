<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group([
    'prefix' => 'v1',
    'namespace' => 'Api',
    'middleware' => 'auth:api',
    'as' => 'api.'
], function () {

    Route::group(['prefix' => 'account'], function () {

        Route::get('requestable/hardware', [
                'as' => 'assets.requestable',
                'uses' => 'AssetsController@requestable'
            ]);

        Route::get('requests', [
                'as' => 'assets.requested',
                'uses' => 'ProfileController@requestedAssets'
            ]);
    });

    /*--- Accessories API ---*/
    // Accessories resource
    Route::apiResource('accessories', 'AccessoriesController', [
        'parameters' => ['accessory' => 'accessory_id']
    ]);

    // Accessories group
    Route::group(['prefix' => 'accessories'], function () {

        Route::get('{accessory}/checkedout', [
            'as' => 'accessories.checkedout',
            'uses' => 'AccessoriesController@checkedout'
        ]);

        Route::post('{accessory}/checkout', [
            'as' => 'accessories.checkout',
            'uses' => 'AccessoriesController@checkout'
        ]);

        Route::post('{accessory}/checkin', [
            'as' => 'accessories.checkin',
            'uses' => 'AccessoriesController@checkin'
        ]);

        Route::get('selectlist', [
            'as' => 'accessories.selectlist',
            'uses' => 'AccessoriesController@selectlist'
        ]);
    }); // Accessories group


    /*--- Categories API ---*/
    Route::group(['prefix' => 'categories'], function () {
        Route::get('{item_type}/selectlist', [
                'as' => 'categories.selectlist',
                'uses' => 'CategoriesController@selectlist'
            ]);
    }); // Categories group

    Route::apiResource('categories', 'CategoriesController', [
        'parameters' => ['category' => 'category_id']
    ]); // Categories resource


    /*--- Companies API ---*/
    Route::get('companies/selectlist', [
        'as' => 'companies.selectlist',
        'uses' => 'CompaniesController@selectlist'
    ]);

    // Companies resource
    Route::apiResource('companies', 'CompaniesController', [
        'parameters' => ['component' => 'component_id']
    ]); // Companies resource


    /*--- Components API ---*/
    Route::apiResource('components', 'ComponentsController', [
        'parameters' => ['component' => 'component_id']
    ]); // Components resource

    Route::group(['prefix' => 'components'], function () {
        Route::get('{component}/assets', [
            'as' =>'components.assets',
            'uses' => 'ComponentsController@getAssets',
        ]);
    }); // Components group


    /*--- Consumables API ---*/
    Route::group(['prefix' => 'consumables'], function () {
        Route::get('selectlist', [
            'as' => 'consumables.selectlist',
            'uses' => 'ConsumablesController@selectlist'
        ]);

        Route::get('view/{id}/users', [
            'as' => 'consumables.showUsers',
            'uses' => 'ConsumablesController@getDataView'
        ]);
    });

    Route::apiResource('consumables', 'ConsumablesController', [
        'parameters' => ['consumable' => 'consumable_id']
    ]); // Consumables resource


    /*--- Departments API ---*/
    Route::group(['prefix' => 'departments'], function () {
        Route::get('selectlist', [
            'as' => 'departments.selectlist',
            'uses' => 'DepartmentsController@selectlist'
        ]);
    }); // Departments group

    Route::apiResource('departments', 'DepartmentsController', [
        'parameters' => ['department' => 'department_id']
    ]); // Departments resource


    /*--- Depreciations API ---*/
    Route::apiResource('depreciations', 'DepreciationsController', [
        'parameters' => ['depreciation' => 'depreciation_id']
    ]); // Depreciations resource


    /*--- Fields API ---*/
    Route::apiResource('fields', 'CustomFieldsController', [
        'parameters' => [ 'field' => 'field_id' ]
    ]);

    Route::group(['prefix' => 'fields'], function () {
        Route::post('fieldsets/{id}/order', [
            'as' => 'customfields.order',
            'uses' => 'CustomFieldsController@postReorder'
        ]);
        Route::post('{field}/associate', [
            'as' => 'customfields.associate',
            'uses' => 'CustomFieldsController@associate'
        ]);
        Route::post('{field}/disassociate', [
            'as' => 'customfields.disassociate',
            'uses' => 'CustomFieldsController@disassociate'
        ]);
    }); // Fields group


    /*--- Fieldsets API ---*/

    Route::group(['prefix' => 'fieldsets'], function () {
        Route::get('{fieldset}/fields', [
            'as' => 'fieldsets.fields',
            'uses' => 'CustomFieldsetsController@fields'
        ]);
        Route::get('/{fieldset}/fields/{model}', [
            'as' => 'fieldsets.fields-with-default-value',
            'uses' => 'CustomFieldsetsController@fieldsWithDefaultValues'
        ]);
    });

    Route::apiResource('fieldsets', 'CustomFieldsetsController', [
        'parameters' => ['fieldset' => 'fieldset_id']
    ]); // Custom fieldset resource


    /*--- Groups API ---*/
    Route::apiResource('groups', 'GroupsController', [
        'parameters' => ['group' => 'group_id']
    ]); // Groups resource


    /*--- Hardware API ---*/
    Route::group(['prefix' => 'hardware'], function () {
        Route::get('{asset_id}/licenses', [
            'as' => 'assets.licenselist',
            'uses' => 'AssetsController@licenses'
        ]);

        Route::get('bytag/{tag}', [
            'as' => 'assets.show.bytag',
            'uses' => 'AssetsController@showByTag'
        ]);

        Route::get('bytag/{any}', [
            'as' => 'assets.show.bytag',
            'uses' => 'AssetsController@showByTag'
        ])->where('any', '.*');

        Route::get('byserial/{any}', [
                'as' => 'assets.show.byserial',
                'uses' => 'AssetsController@showBySerial'
        ])->where('any', '.*');

        Route::get('selectlist', [
            'as' => 'assets.selectlist',
            'uses' => 'AssetsController@selectlist'
        ]);

        Route::get('audit/{audit}', [
            'as' => 'asset.to-audit',
            'uses' => 'AssetsController@index'
        ]);

        Route::post('audit', [
            'as' => 'asset.audit',
            'uses' => 'AssetsController@audit'
        ]);

        Route::post('{asset_id}/checkout', [
            'as' => 'assets.checkout',
            'uses' => 'AssetsController@checkout'
        ]);

        Route::post('{asset_id}/checkin', [
            'as' => 'assets.checkin',
            'uses' => 'AssetsController@checkin'
        ]);
    });

    Route::apiResource('hardware', 'AssetsController', [
        // Names need to remain here as laravel defaults to 'hardware' given the routes used.
        'names' => [
            'index' => 'assets.index',
            'show' => 'assets.show',
            'store' => 'assets.store',
            'update' => 'assets.update',
            'destroy' => 'assets.destroy'
        ],
        'parameters' => ['asset' => 'asset_id']
    ]); // Hardware resource


    /*--- Imports API ---*/
    Route::apiResource('imports', 'ImportController', [
        'parameters' => ['import' => 'import_id']
    ]);

    Route::group(['prefix' => 'imports'], function () {
        Route::post('process/{import}', [
            'as' => 'imports.importFile',
            'uses'=> 'ImportController@process'
        ]);
    }); // Imports group


    /*--- Licenses API ---*/
    Route::group(['prefix' => 'licenses'], function () {
        Route::get('{licenseId}/seats', [
            'as' => 'license.seats',
            'uses' => 'LicensesController@seats'
        ]);

        Route::get('selectlist', [
            'as' => 'licenses.selectlist',
            'uses'=> 'LicensesController@selectlist'
        ]);
    }); // Licenses group

    Route::apiResource('licenses', 'LicensesController', [
        'parameters' => ['license' => 'license_id']
    ]); // Licenses resource


    /*--- Locations API ---*/
    Route::group(['prefix' => 'locations'], function () {
        Route::get('{location}/users', [
            'as'=>'locations.viewusers',
            'uses'=>'LocationsController@getDataViewUsers'
        ]);

        Route::get('{location}/assets', [
            'as'=>'locations.viewassets',
            'uses'=>'LocationsController@getDataViewAssets'
        ]);

        // Do we actually still need this, now that we have an API?
        Route::get('{location}/check', [
            'as' => 'locations.check',
            'uses' => 'LocationsController@show'
        ]);

        Route::get('selectlist', [
            'as' => 'locations.selectlist',
            'uses' => 'LocationsController@selectlist'
        ]);
    }); // Locations group

    Route::apiResource('locations', 'LocationsController', [
        'parameters' => ['location' => 'location_id']
    ]);

    /*--- Asset Maintenances API ---*/
    Route::apiResource('maintenances', 'AssetMaintenancesController', [
        'parameters' => ['maintenance' => 'maintenance_id']
    ]); // Consumables resource

    /*--- Manufacturers API ---*/
    Route::group(['prefix' => 'manufacturers'], function () {
        Route::get('selectlist', [
            'as' => 'manufacturers.selectlist',
            'uses' => 'ManufacturersController@selectlist'
        ]);
    }); // Manufacturers group

    Route::apiResource('manufacturers', 'ManufacturersController', [
        'parameters' => ['manufacturer' => 'manufacturer_id']
    ]);


    /*--- Models API ---*/
    Route::group(['prefix' => 'models'], function () {
        Route::get('assets', [
            'as' => 'models.assets',
            'uses'=> 'AssetModelsController@assets'
        ]);
        Route::get('selectlist', [
            'as' => 'models.selectlist',
            'uses'=> 'AssetModelsController@selectlist'
        ]);
    }); // Models group

    Route::apiResource('models', 'AssetModelsController', [
        'parameters' => ['model' => 'model_id']
    ]);

    /*--- Settings API ---*/
    Route::group(['prefix' => 'settings'], function () {
        Route::get('ldaptest', [
            'as' => 'settings.ldaptest',
            'uses' => 'SettingsController@ldapAdSettingsTest'
        ]);

        Route::get('login-attempts', [
            'middleware' => ['auth', 'authorize:superuser'],
            'as' => 'settings.login_attempts',
            'uses' => 'SettingsController@showLoginAttempts'
        ]);

        Route::post('ldaptestlogin', [
            'as' => 'settings.ldaptestlogin',
            'uses' => 'SettingsController@ldaptestlogin'
        ]);

        Route::post('slacktest', [
            'as' => 'settings.slacktest',
            'uses' => 'SettingsController@slacktest'
        ]);

        Route::post('mailtest', [
            'as'  => 'settings.mailtest',
            'uses' => 'SettingsController@ajaxTestEmail'
        ]);
    }); // Settings group

    Route::apiResource('settings', 'SettingsController', [
        'except' => ['destroy'],
        'parameters' => ['setting' => 'setting_id']
    ]);


    /*--- Status Labels API ---*/
    Route::group(['prefix' => 'statuslabels'], function () {

        // Pie chart for dashboard
        Route::get('assets', [
            'as' => 'statuslabels.assets.bytype',
            'uses' => 'StatuslabelsController@getAssetCountByStatuslabel'
        ]);

        Route::get('{statuslabel}/assetlist', [
            'as' => 'statuslabels.assets',
            'uses' => 'StatuslabelsController@assets'
        ]);

        Route::get('{statuslabel}/deployable', [
            'as' => 'statuslabels.deployable',
            'uses' => 'StatuslabelsController@checkIfDeployable'
        ]);
    });  // Status labels group

    Route::apiResource('statuslabels', 'StatuslabelsController', [
        'parameters' => ['statuslabel' => 'statuslabel_id']
    ]);


    /*--- Suppliers API ---*/
    Route::group(['prefix' => 'suppliers'], function () {
        Route::get('selectlist', [
            'as' => 'suppliers.selectlist',
            'uses' => 'SuppliersController@selectlist'
        ]);
    }); // Suppliers group

    Route::apiResource('suppliers', 'SuppliersController', [
        'parameters' => ['supplier' => 'supplier_id']
    ]);


    /*--- Users API ---*/
    Route::group([ 'prefix' => 'users' ], function () {

        Route::post('two_factor_reset', [
            'as' => 'users.two_factor_reset',
            'uses' => 'UsersController@postTwoFactorReset'
        ]);

        Route::get('me', [
            'as' => 'users.me',
            'uses' => 'UsersController@getCurrentUserInfo'
        ]);

        Route::get('selectlist', [
            'as' => 'users.selectlist',
            'uses' => 'UsersController@selectList'
        ]);

        Route::get('{user}/assets', [
            'as' => 'users.assetlist',
            'uses' => 'UsersController@assets'
        ]);

        Route::get('{user}/licenses', [
            'as' => 'users.licenselist',
            'uses' => 'UsersController@licenses'
        ]);

        Route::post('{user}/upload', [
            'as' => 'users.uploads',
            'uses' => 'UsersController@postUpload'
        ]);
    }); // Users group

    Route::apiResource('users', 'UsersController', [
        'parameters' => ['user' => 'user_id']
    ]); // Users resource


    Route::get('reports/activity', [
        'as' => 'activity.index',
        'uses' => 'ReportsController@index',
    ]);

    /*--- Kits API ---*/

    Route::apiResource('kits', 'PredefinedKitsController', [
        'parameters' => ['kit' => 'kit_id']
    ]);


    Route::group([ 'prefix' => 'kits/{kit_id}' ], function () {

        // kit licenses
        Route::get('licenses', [
            'as' => 'kits.licenses.index',
            'uses' => 'PredefinedKitsController@indexLicenses',
        ]);

        Route::post('licenses', [
            'as' => 'kits.licenses.store',
            'uses' => 'PredefinedKitsController@storeLicense',
        ]);

        Route::put('licenses/{license_id}', [
            'as' => 'kits.licenses.update',
            'uses' => 'PredefinedKitsController@updateLicense',
        ]);

        Route::delete('licenses/{license_id}', [
            'as' => 'kits.licenses.destroy',
            'uses' => 'PredefinedKitsController@detachLicense',
        ]);

        // kit models
        Route::get('models', [
            'as' => 'kits.models.index',
            'uses' => 'PredefinedKitsController@indexModels',
        ]);

        Route::post('models', [
            'as' => 'kits.models.store',
            'uses' => 'PredefinedKitsController@storeModel',
        ]);

        Route::put('models/{model_id}', [
            'as' => 'kits.models.update',
            'uses' => 'PredefinedKitsController@updateModel',
        ]);

        Route::delete('models/{model_id}', [
            'as' => 'kits.models.destroy',
            'uses' => 'PredefinedKitsController@detachModel',
        ]);

        // kit accessories
        Route::get('accessories', [
            'as' => 'kits.accessories.index',
            'uses' => 'PredefinedKitsController@indexAccessories',
        ]);

        Route::post('accessories', [
            'as' => 'kits.accessories.store',
            'uses' => 'PredefinedKitsController@storeAccessory',
        ]);

        Route::put('accessories/{accessory_id}', [
            'as' => 'kits.accessories.update',
            'uses' => 'PredefinedKitsController@updateAccessory',
        ]);

        Route::delete('accessories/{accessory_id}', [
            'as' => 'kits.accessories.destroy',
            'uses' => 'PredefinedKitsController@detachAccessory',
        ]);

        // kit consumables
        Route::get('consumables', [
            'as' => 'kits.consumables.index',
            'uses' => 'PredefinedKitsController@indexConsumables',
        ]);

        Route::post('consumables', [
            'as' => 'kits.consumables.store',
            'uses' => 'PredefinedKitsController@storeConsumable',
        ]);

        Route::put('{consumable_id}', [
            'as' => 'kits.consumables.update',
            'uses' => 'PredefinedKitsController@updateConsumable',
        ]);

        Route::delete('consumables/{consumable_id}', [
            'as' => 'kits.consumables.destroy',
            'uses' => 'PredefinedKitsController@detachConsumable',
        ]);
    }); // kits group
});
