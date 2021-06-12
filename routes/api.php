<?php

use App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*******************************************************************************************************************************
 * 
 * FIXME FIXME FIXME
 * 
 * The 'old' way of specifying routes (an array with 'as' for a name, and 'uses' for a controller) doesn't seem to work anymore.
 * Almost all of these routes will need to be fixed (as has been done in the web.php routes file). Hopefully, a later version of
 * Laravel Shift will do it for us maybe? Or we can get to it at some point later.
 * 
 ******************************************************************************************************************************/

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

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
    Route::get('/', function () {
        return response()->json(
            [
                'status' => 'error',
                'message' => '404 endpoint not found. This is the base URL for the API and does not return anything itself. Please check the API reference at https://snipe-it.readme.io/reference to find a valid API endpoint.',
                'payload' => null,
            ], 404);
    });

    Route::group(['prefix' => 'account'], function () {
        Route::get('requestable/hardware',
            [
                'as' => 'api.assets.requestable',
                'uses' => [Api\AssetsController::class, 'requestable'],
            ]
        );

        Route::get('requests',
            [
                'as' => 'api.assets.requested',
                'uses' => [Api\ProfileController::class, 'requestedAssets'],
            ]
        );
    });

    /*--- Accessories API ---*/
    Route::group(['prefix' => 'accessories'], function () {
        Route::get('{accessory}/checkedout',
            [
                'as' => 'api.accessories.checkedout',
                'uses' => [Api\AccessoriesController::class, 'checkedout'],
            ]
        );

        Route::get('selectlist',
            [
                'as' => 'api.accessories.selectlist',
                'uses'=> [Api\AccessoriesController::class, 'selectlist'],
            ]
        );
    });

    // Accessories group
    Route::resource('accessories', Api\AccessoriesController::class,
        ['names' => [
                'index' => 'api.accessories.index',
                'show' => 'api.accessories.show',
                'update' => 'api.accessories.update',
                'store' => 'api.accessories.store',
                'destroy' => 'api.accessories.destroy',
            ],
            'except' => ['create', 'edit'],
            'parameters' => ['accessory' => 'accessory_id'],
        ]
    );

    // Accessories resource

    Route::group(['prefix' => 'accessories'], function () {
        Route::get('{accessory}/checkedout',
            [
                'as' => 'api.accessories.checkedout',
                'uses' => [Api\AccessoriesController::class, 'checkedout'],
            ]
        );

        Route::post('{accessory}/checkout',
            [
                'as' => 'api.accessories.checkout',
                'uses' => [Api\AccessoriesController::class, 'checkout'],
            ]
        );

        Route::post('{accessory}/checkin',
            [
                'as' => 'api.accessories.checkin',
                'uses' => [Api\AccessoriesController::class, 'checkin'],
            ]
        );
    }); // Accessories group

    /*--- Categories API ---*/

    Route::group(['prefix' => 'categories'], function () {
        Route::get('{item_type}/selectlist',
            [
                'as' => 'api.categories.selectlist',
                'uses' => [Api\CategoriesController::class, 'selectlist'],
            ]
        );
    });

    // Categories group
    Route::resource('categories', Api\CategoriesController::class,
        [
            'names' => [
                    'index' => 'api.categories.index',
                    'show' => 'api.categories.show',
                    'store' => 'api.categories.store',
                    'update' => 'api.categories.update',
                    'destroy' => 'api.categories.destroy',
                ],
            'except' => ['edit', 'create'],
            'parameters' => ['category' => 'category_id'],
        ]
    ); // Categories resource

    /*--- Companies API ---*/

    Route::get('companies/selectlist', [
        'as' => 'companies.selectlist',
        'uses' => [Api\CompaniesController::class, 'selectlist'],
    ]);

    // Companies resource
    Route::resource('companies', Api\CompaniesController::class,
        [
            'names' => [
                    'index' => 'api.companies.index',
                    'show' => 'api.companies.show',
                    'store' => 'api.companies.store',
                    'update' => 'api.companies.update',
                    'destroy' => 'api.companies.destroy',
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['component' => 'component_id'],
        ]
    ); // Companies resource

    /*--- Departments API ---*/

    Route::group(['prefix' => 'departments'], function () {
        Route::get('selectlist',
            [
                'as' => 'api.departments.selectlist',
                'uses' => [Api\DepartmentsController::class, 'selectlist'],
            ]
        );
    }); // Departments group

    Route::resource('departments', Api\DepartmentsController::class,
        [
            'names' => [
                    'index' => 'api.departments.index',
                    'show' => 'api.departments.show',
                    'store' => 'api.departments.store',
                    'update' => 'api.departments.update',
                    'destroy' => 'api.departments.destroy',
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['department' => 'department_id'],
        ]
    ); // Departments resource

    /*--- Components API ---*/

    Route::resource('components', Api\ComponentsController::class,
        [
            'names' => [
                    'index' => 'api.components.index',
                    'show' => 'api.components.show',
                    'store' => 'api.components.store',
                    'update' => 'api.components.update',
                    'destroy' => 'api.components.destroy',
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['component' => 'component_id'],
        ]
    ); // Components resource

    Route::group(['prefix' => 'components'], function () {
        Route::get('{component}/assets',
            [
                'as' =>'api.components.assets',
                'uses' => [Api\ComponentsController::class, 'getAssets'],
            ]
        );
    }); // Components group

    /*--- Consumables API ---*/
    Route::get('consumables/selectlist',
        [
            'as' => 'api.consumables.selectlist',
            'uses'=> [Api\ConsumablesController::class, 'selectlist'],
        ]
    );

    Route::resource('consumables', Api\ConsumablesController::class,
        [
            'names' => [
                    'index' => 'api.consumables.index',
                    'show' => 'api.consumables.show',
                    'store' => 'api.consumables.store',
                    'update' => 'api.consumables.update',
                    'destroy' => 'api.consumables.destroy',
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['consumable' => 'consumable_id'],
        ]
    ); // Consumables resource

    Route::group(['prefix' => 'consumables'], function () {
        Route::get('view/{id}/users',
            [
                'as' => 'api.consumables.showUsers',
                'uses' => [Api\ConsumablesController::class, 'getDataView'],
            ]
        );

        Route::post('{consumable}/checkout',
            [
                'as' => 'api.consumables.checkout',
                'uses' => [Api\ConsumablesController::class, 'checkout'],
            ]
        );
    });

    /*--- Depreciations API ---*/

    Route::resource('depreciations', Api\DepreciationsController::class,
        [
            'names' => [
                    'index' => 'api.depreciations.index',
                    'show' => 'api.depreciations.show',
                    'store' => 'api.depreciations.store',
                    'update' => 'api.depreciations.update',
                    'destroy' => 'api.depreciations.destroy',
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['depreciation' => 'depreciation_id'],
        ]
    ); // Depreciations resource

    /*--- Fields API ---*/

    Route::resource('fields', Api\CustomFieldsController::class, [
        'names' => [
            'index' => 'api.customfields.index',
            'show' => 'api.customfields.show',
            'store' => 'api.customfields.store',
            'update' => 'api.customfields.update',
            'destroy' => 'api.customfields.destroy',
        ],
        'except' => ['create', 'edit'],
        'parameters' => ['field' => 'field_id'],
    ]);

    Route::group(['prefix' => 'fields'], function () {
        Route::post('fieldsets/{id}/order',
            [
                'as' => 'api.customfields.order',
                'uses' => [Api\CustomFieldsController::class, 'postReorder'],
            ]
        );
        Route::post('{field}/associate',
            [
                'as' => 'api.customfields.associate',
                'uses' => [Api\CustomFieldsController::class, 'associate'],
            ]
        );
        Route::post('{field}/disassociate',
            [
                'as' => 'api.customfields.disassociate',
                'uses' => [Api\CustomFieldsController::class, 'disassociate'],
            ]
        );
    }); // Fields group

    /*--- Fieldsets API ---*/

    Route::group(['prefix' => 'fieldsets'], function () {
        Route::get('{fieldset}/fields',
            [
                'as' => 'api.fieldsets.fields',
                'uses' => [Api\CustomFieldsetsController::class, 'fields'],
            ]
        );
        Route::get('/{fieldset}/fields/{model}',
            [
                'as' => 'api.fieldsets.fields-with-default-value',
                'uses' => [Api\CustomFieldsetsController::class, 'fieldsWithDefaultValues'],
            ]
        );
    });

    Route::resource('fieldsets', Api\CustomFieldsetsController::class,
        [
            'names' => [
                    'index' => 'api.fieldsets.index',
                    'show' => 'api.fieldsets.show',
                    'store' => 'api.fieldsets.store',
                    'update' => 'api.fieldsets.update',
                    'destroy' => 'api.fieldsets.destroy',
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['fieldset' => 'fieldset_id'],
        ]
    ); // Custom fieldset resource

    /*--- Groups API ---*/

    Route::resource('groups', Api\GroupsController::class,
        [
            'names' => [
                    'index' => 'api.groups.index',
                    'show' => 'api.groups.show',
                    'store' => 'api.groups.store',
                    'update' => 'api.groups.update',
                    'destroy' => 'api.groups.destroy',
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['group' => 'group_id'],
        ]
    ); // Groups resource

    /*--- Hardware API ---*/

    Route::group(['prefix' => 'hardware'], function () {
        Route::get('{asset_id}/licenses', [
            'as' => 'api.assets.licenselist',
            'uses' => [Api\AssetsController::class, 'licenses'],
        ]);

        Route::get('bytag/{tag}', [
            'as' => 'assets.show.bytag',
            'uses' => [Api\AssetsController::class, 'showByTag'],
        ]);

        Route::get('bytag/{any}',
            [
                'as' => 'api.assets.show.bytag',
                'uses' => [Api\AssetsController::class, 'showByTag'],
            ]
        )->where('any', '.*');

        Route::get('byserial/{any}',
            [
                'as' => 'api.assets.show.byserial',
                'uses' => [Api\AssetsController::class, 'showBySerial'],
            ]
         )->where('any', '.*');

        Route::get('selectlist', [
            'as' => 'assets.selectlist',
            'uses' => [Api\AssetsController::class, 'selectlist'],
        ]);

        Route::get('audit/{audit}', [
            'as' => 'api.asset.to-audit',
            'uses' => [Api\AssetsController::class, 'index'],
        ]);

        Route::post('audit', [
            'as' => 'api.asset.audit',
            'uses' => [Api\AssetsController::class, 'audit'],
        ]);

        Route::post('{asset_id}/checkout',
            [
                'as' => 'api.assets.checkout',
                'uses' => [Api\AssetsController::class, 'checkout'],
            ]
        );

        Route::post('{asset_id}/checkin',
            [
                'as' => 'api.assets.checkin',
                'uses' => [Api\AssetsController::class, 'checkin'],
            ]
        );
    });

    /*--- Asset Maintenances API ---*/
    Route::resource('maintenances', Api\AssetMaintenancesController::class,
        [
            'names' => [
                    'index' => 'api.maintenances.index',
                    'show' => 'api.maintenances.show',
                    'store' => 'api.maintenances.store',
                    'update' => 'api.maintenances.update',
                    'destroy' => 'api.maintenances.destroy',
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['maintenance' => 'maintenance_id'],
        ]
    ); // Consumables resource

    Route::resource('hardware', Api\AssetsController::class,
        [
            'names' => [
                    'index' => 'api.assets.index',
                    'show' => 'api.assets.show',
                    'store' => 'api.assets.store',
                    'update' => 'api.assets.update',
                    'destroy' => 'api.assets.destroy',
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['asset' => 'asset_id'],
        ]
    ); // Hardware resource

    /*--- Imports API ---*/

    Route::resource('imports', Api\ImportController::class,
        [
            'names' => [
                    'index' => 'api.imports.index',
                    'show' => 'api.imports.show',
                    'store' => 'api.imports.store',
                    'update' => 'api.imports.update',
                    'destroy' => 'api.imports.destroy',
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['import' => 'import_id'],
        ]
    ); // Imports resource

    Route::group(['prefix' => 'imports'], function () {
        Route::post('process/{import}',
            [
                'as' => 'api.imports.importFile',
                'uses'=> [Api\ImportController::class, 'process'],
            ]
        );
    }); // Imports group

    /*--- Licenses API ---*/

    Route::group(['prefix' => 'licenses'], function () {
        Route::get('selectlist',
            [
                'as' => 'api.licenses.selectlist',
                'uses'=> [Api\LicensesController::class, 'selectlist'],
            ]
        );
    }); // Licenses group

    Route::resource('licenses', Api\LicensesController::class,
        [
            'names' => [
                    'index' => 'api.licenses.index',
                    'show' => 'api.licenses.show',
                    'store' => 'api.licenses.store',
                    'update' => 'api.licenses.update',
                    'destroy' => 'api.licenses.destroy',
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['license' => 'license_id'],
        ]
    ); // Licenses resource

    Route::resource('licenses.seats', Api\LicenseSeatsController::class,
        [
            'names' => [
                    'index' => 'api.licenses.seats.index',
                    'show' => 'api.licenses.seats.show',
                    'update' => 'api.licenses.seats.update',
                ],
            'except' => ['create', 'edit', 'destroy', 'store'],
            'parameters' => ['licenseseat' => 'licenseseat_id'],
        ]
    ); // Licenseseats resource

    /*--- Locations API ---*/

    Route::group(['prefix' => 'locations'], function () {
        Route::get('{location}/users',
            [
                'as'=>'api.locations.viewusers',
                'uses'=>[Api\LocationsController::class, 'getDataViewUsers'],
            ]
        );

        Route::get('{location}/assets',
            [
                'as'=>'api.locations.viewassets',
                'uses'=>[Api\LocationsController::class, 'getDataViewAssets'],
            ]
        );

        // Do we actually still need this, now that we have an API?
        Route::get('{location}/check',
            [
                'as' => 'api.locations.check',
                'uses' => [Api\LocationsController::class, 'show'],
            ]
        );

        Route::get('selectlist', [
            'as' => 'locations.selectlist',
            'uses' => [Api\LocationsController::class, 'selectlist'],
        ]);
    }); // Locations group

    Route::resource('locations', Api\LocationsController::class,
        [
            'names' => [
                    'index' => 'api.locations.index',
                    'show' => 'api.locations.show',
                    'store' => 'api.locations.store',
                    'update' => 'api.locations.update',
                    'destroy' => 'api.locations.destroy',
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['location' => 'location_id'],
        ]
    ); // Locations resource

    /*--- Manufacturers API ---*/

    Route::group(['prefix' => 'manufacturers'], function () {
        Route::get('selectlist', [
            'as' => 'manufacturers.selectlist',
            'uses' => [Api\ManufacturersController::class, 'selectlist'],
        ]);
    }); // Locations group

    Route::resource('manufacturers', Api\ManufacturersController::class,
        [
            'names' => [
                    'index' => 'api.manufacturers.index',
                    'show' => 'api.manufacturers.show',
                    'store' => 'api.manufacturers.store',
                    'update' => 'api.manufacturers.update',
                    'destroy' => 'api.manufacturers.destroy',
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['manufacturer' => 'manufacturer_id'],
        ]
    ); // Manufacturers resource

    /*--- Models API ---*/

    Route::group(['prefix' => 'models'], function () {
        Route::get('assets',
            [
                'as' => 'api.models.assets',
                'uses'=> [Api\AssetModelsController::class, 'assets'],
            ]
        );
        Route::get('selectlist',
            [
                'as' => 'api.models.selectlist',
                'uses'=> [Api\AssetModelsController::class, 'selectlist'],
            ]
        );
    }); // Models group

    Route::resource('models', Api\AssetModelsController::class,
        [
            'names' => [
                    'index' => 'api.models.index',
                    'show' => 'api.models.show',
                    'store' => 'api.models.store',
                    'update' => 'api.models.update',
                    'destroy' => 'api.models.destroy',
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['model' => 'model_id'],
        ]
    ); // Models resource

    /*--- Settings API ---*/
    Route::get('settings/ldaptest', [
        'as' => 'api.settings.ldaptest',
        'uses' => [Api\SettingsController::class, 'ldapAdSettingsTest'],
    ]);

    Route::post('settings/purge_barcodes', [
        'as' => 'api.settings.purgebarcodes',
        'uses' => [Api\SettingsController::class, 'purgeBarcodes'],
    ]);

    Route::get('settings/login-attempts', [
        'middleware' => ['auth', 'authorize:superuser'],
        'as' => 'api.settings.login_attempts',
        'uses' => [Api\SettingsController::class, 'showLoginAttempts'],
    ]);

    Route::post('settings/ldaptestlogin', [
        'as' => 'api.settings.ldaptestlogin',
        'uses' => [Api\SettingsController::class, 'ldaptestlogin'],
    ]);

    Route::post('settings/slacktest', [
        'as' => 'api.settings.slacktest',
        'uses' => [Api\SettingsController::class, 'slacktest'],
    ]);

    Route::post(
        'settings/mailtest',
        [
            'as'  => 'api.settings.mailtest',
            'uses' => [Api\SettingsController::class, 'ajaxTestEmail'],
    ]);

    Route::resource('settings', Api\SettingsController::class,
        [
            'names' => [
                    'index' => 'api.settings.index',
                    'store' => 'api.settings.store',
                    'show' => 'api.settings.show',
                    'update' => 'api.settings.update',
                ],
            'except' => ['create', 'edit', 'destroy'],
            'parameters' => ['setting' => 'setting_id'],
        ]
    ); // Settings resource

    /*--- Status Labels API ---*/

    Route::group(['prefix' => 'statuslabels'], function () {

        // Pie chart for dashboard
        Route::get('assets', [Api\StatuslabelsController::class, 'getAssetCountByStatuslabel']
            // [
            //     'as' => 'api.statuslabels.assets.bytype',
            //     'uses' => [Api\StatuslabelsController::class, 'getAssetCountByStatuslabel'],
            // ]
        )->name('api.statuslabels.assets.bytype');

        Route::get('{statuslabel}/assetlist',
            [
                'as' => 'api.statuslabels.assets',
                'uses' => [Api\StatuslabelsController::class, 'assets'],
            ]
        );

        Route::get('{statuslabel}/deployable',
            [
                'as' => 'api.statuslabels.deployable',
                'uses' => [Api\StatuslabelsController::class, 'checkIfDeployable'],
            ]
        );
    });

    Route::resource('statuslabels', Api\StatuslabelsController::class,
        [
            'names' => [
                    'index' => 'api.statuslabels.index',
                    'store' => 'api.statuslabels.store',
                    'show' => 'api.statuslabels.show',
                    'update' => 'api.statuslabels.update',
                    'destroy' => 'api.statuslabels.destroy',
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['statuslabel' => 'statuslabel_id'],
        ]
    );

    // Status labels group

    /*--- Suppliers API ---*/
    Route::group(['prefix' => 'suppliers'], function () {
        Route::get('list',
            [
                'as'=>'api.suppliers.list',
                'uses'=>[Api\SuppliersController::class, 'getDatatable'],
            ]
        );

        Route::get('selectlist',
            [
                'as' => 'api.suppliers.selectlist',
                'uses' => [Api\SuppliersController::class, 'selectlist'],
            ]
        );
    }); // Suppliers group

    Route::resource('suppliers', Api\SuppliersController::class,
        [
            'names' => [
                    'index' => 'api.suppliers.index',
                    'show' => 'api.suppliers.show',
                    'store' => 'api.suppliers.store',
                    'update' => 'api.suppliers.update',
                    'destroy' => 'api.suppliers.destroy',
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['supplier' => 'supplier_id'],
        ]
    ); // Suppliers resource

    /*--- Users API ---*/

    Route::group(['prefix' => 'users'], function () {
        Route::post('two_factor_reset',
            [
                'as' => 'api.users.two_factor_reset',
                'uses' => [Api\UsersController::class, 'postTwoFactorReset'],
            ]
        );

        Route::get('me',
            [
                'as' => 'api.users.me',
                'uses' => [Api\UsersController::class, 'getCurrentUserInfo'],
            ]
        );

        Route::get('list/{status?}',
            [
                'as' => 'api.users.list',
                'uses' => [Api\UsersController::class, 'getDatatable'],
            ]
        );

        Route::get('selectlist',
            [
                'as' => 'api.users.selectlist',
                'uses' => [Api\UsersController::class, 'selectList'],
            ]
        );

        Route::get('{user}/assets',
            [
                'as' => 'api.users.assetlist',
                'uses' => [Api\UsersController::class, 'assets'],
            ]
        );

        Route::get('{user}/accessories',
            [
                'as' => 'api.users.accessorieslist',
                'uses' => [Api\UsersController::class, 'accessories'],
            ]
        );

        Route::get('{user}/licenses',
            [
                'as' => 'api.users.licenselist',
                'uses' => [Api\UsersController::class, 'licenses'],
            ]
        );

        Route::post('{user}/upload',
            [
                'as' => 'api.users.uploads',
                'uses' => [Api\UsersController::class, 'postUpload'],
            ]
        );
    }); // Users group

    Route::resource('users', Api\UsersController::class,
        [
            'names' => [
                    'index' => 'api.users.index',
                    'show' => 'api.users.show',
                    'store' => 'api.users.store',
                    'update' => 'api.users.update',
                    'destroy' => 'api.users.destroy',
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['user' => 'user_id'],
        ]
    ); // Users resource

    Route::get(
        'reports/activity', 
        [Api\ReportsController::class, 'index']
        // ['as' => 'api.activity.index', 'uses' => [Api\ReportsController::class, 'index']]
    )->name('api.activity.index');

    /*--- Kits API ---*/

    Route::resource('kits', Api\PredefinedKitsController::class,
        [
            'names' => [
                    'index' => 'api.kits.index',
                    'show' => 'api.kits.show',
                    'store' => 'api.kits.store',
                    'update' => 'api.kits.update',
                    'destroy' => 'api.kits.destroy',
                ],
            'except' => ['create', 'edit'],
            'parameters' => ['kit' => 'kit_id'],
        ]
    );

    Route::group(['prefix' => 'kits/{kit_id}'], function () {

        // kit licenses
        Route::get('licenses',
            [
                'as' => 'api.kits.licenses.index',
                'uses' => [Api\PredefinedKitsController::class, 'indexLicenses'],
            ]
        );

        Route::post('licenses',
            [
                'as' => 'api.kits.licenses.store',
                'uses' => [Api\PredefinedKitsController::class, 'storeLicense'],
            ]
        );

        Route::put('licenses/{license_id}',
            [
                'as' => 'api.kits.licenses.update',
                'uses' => [Api\PredefinedKitsController::class, 'updateLicense'],
            ]
        );

        Route::delete('licenses/{license_id}',
            [
                'as' => 'api.kits.licenses.destroy',
                'uses' => [Api\PredefinedKitsController::class, 'detachLicense'],
            ]
        );

        // kit models
        Route::get('models',
            [
                'as' => 'api.kits.models.index',
                'uses' => [Api\PredefinedKitsController::class, 'indexModels'],
            ]
        );

        Route::post('models',
            [
                'as' => 'api.kits.models.store',
                'uses' => [Api\PredefinedKitsController::class, 'storeModel'],
            ]
        );

        Route::put('models/{model_id}',
            [
                'as' => 'api.kits.models.update',
                'uses' => [Api\PredefinedKitsController::class, 'updateModel'],
            ]
        );

        Route::delete('models/{model_id}',
            [
                'as' => 'api.kits.models.destroy',
                'uses' => [Api\PredefinedKitsController::class, 'detachModel'],
            ]
        );

        // kit accessories
        Route::get('accessories',
            [
                'as' => 'api.kits.accessories.index',
                'uses' => [Api\PredefinedKitsController::class, 'indexAccessories'],
            ]
        );

        Route::post('accessories',
            [
                'as' => 'api.kits.accessories.store',
                'uses' => [Api\PredefinedKitsController::class, 'storeAccessory'],
            ]
        );

        Route::put('accessories/{accessory_id}',
            [
                'as' => 'api.kits.accessories.update',
                'uses' => [Api\PredefinedKitsController::class, 'updateAccessory'],
            ]
        );

        Route::delete('accessories/{accessory_id}',
            [
                'as' => 'api.kits.accessories.destroy',
                'uses' => [Api\PredefinedKitsController::class, 'detachAccessory'],
            ]
        );

        // kit consumables
        Route::get('consumables',
            [
                'as' => 'api.kits.consumables.index',
                'uses' => [Api\PredefinedKitsController::class, 'indexConsumables'],
            ]
        );

        Route::post('consumables',
            [
                'as' => 'api.kits.consumables.store',
                'uses' => [Api\PredefinedKitsController::class, 'storeConsumable'],
            ]
        );

        Route::put('consumables/{consumable_id}',
            [
                'as' => 'api.kits.consumables.update',
                'uses' => [Api\PredefinedKitsController::class, 'updateConsumable'],
            ]
        );

        Route::delete('consumables/{consumable_id}',
            [
                'as' => 'api.kits.consumables.destroy',
                'uses' => [Api\PredefinedKitsController::class, 'detachConsumable'],
            ]
        );
    }); // kits group

    Route::fallback(function () {
        return response()->json(
            [
                'status' => 'error',
                'message' => '404 endpoint not found. Please check the API reference at https://snipe-it.readme.io/reference to find a valid API endpoint.',
                'payload' => null,
            ], 404);
    });
});
