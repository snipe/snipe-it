<?php

use Illuminate\Http\Request;
use App\Models\CheckoutRequest;
use App\Models\Location;
use App\Models\Statuslabel;

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


Route::group(['prefix' => 'v1','namespace' => 'Api'], function () {

    Route::resource('users', 'UsersController',
        ['names' =>
            [
                'index' => 'api.users.index',
                'show' => 'api.users.show',
                'update' => 'api.users.update',
                'store' => 'api.users.store',
                'destroy' => 'api.users.destroy'
            ],
            'except' => ['edit'],
            'parameters' => ['user' => 'user_id']
        ]
    );


    Route::resource('licenses', 'LicensesController',
        ['names' =>
            [
                'index' => 'api.licenses.index',
                'show' => 'api.licenses.show',
                'update' => 'api.licenses.update',
                'store' => 'api.licenses.store',
                'destroy' => 'api.licenses.destroy'
            ],
            'except' => ['edit'],
            'parameters' => ['license' => 'license_id']
        ]
    );


    Route::resource('models', 'AssetModelsController',
        ['names' =>
            [
                'index' => 'api.models.index',
                'show' => 'api.models.show',
                'update' => 'api.models.update',
                'store' => 'api.models.store',
                'destroy' => 'api.models.destroy'
            ],
            'except' => ['edit', 'create'],
            'parameters' => ['model' => 'model_id']
        ]
    );

    Route::resource('categories', 'CategoriesController',
        ['names' =>
            [
                'index' => 'api.categories.index',
                'show' => 'api.categories.asset.show',
                'update' => 'api.categories.update',
                'store' => 'api.categories.store',
                'destroy' => 'api.categories.destroy'
            ],
            'except' => ['edit', 'create'],
            'parameters' => ['category' => 'category_id']
        ]
    );


    Route::resource('companies', 'CompaniesController',
        ['names' =>
            [
                'index' => 'api.companies.index',
                'show' => 'api.companies.show',
                'update' => 'api.companies.update',
                'store' => 'api.companies.store',
                'destroy' => 'api.companies.destroy'
            ],
            'except' => ['edit'],
            'parameters' => ['component' => 'component_id']
        ]
    );

    Route::resource('locations', 'LocationsController',
        ['names' =>
            [
                'index' => 'api.locations.index',
                'show' => 'api.locations.show',
                'update' => 'api.locations.update',
                'store' => 'api.locations.store',
                'destroy' => 'api.locations.destroy'
            ],
            'except' => ['edit'],
            'parameters' => ['locations' => 'locations_id']
        ]
    );


    Route::resource('components', 'ComponentsController',
        ['names' =>
            [
                'index' => 'api.components.index',
                'show' => 'api.components.show',
                'update' => 'api.components.update',
                'store' => 'api.components.store',
                'destroy' => 'api.components.destroy'
            ],
            'parameters' =>
                ['component' => 'component_id']
        ]
    );


    Route::resource('suppliers', 'SuppliersController',
        ['names' =>
            [
                'index' => 'api.suppliers.index',
                'create' => 'api.suppliers.create',
                'destroy' => 'api.suppliers.destroy'
            ],
            'parameters' =>
                ['supplier' => 'supplier_id']
        ]
    );

    Route::resource('users', 'UsersController',
        ['names' =>
            [
                'index' => 'api.users.index',
                'create' => 'api.users.create',
                'destroy' => 'api.users.destroy'
            ],
            'parameters' =>
                ['user' => 'user_id']
        ]
    );

    Route::resource('settings', 'SettingsController',
        ['names' =>
            [
                'index' => 'api.settings.index',
                'create' => 'api.settings.create'
            ],
            'parameters' =>
                ['setting' => 'setting_id']
        ]
    );


    /*---Status Label API---*/
    Route::group([ 'prefix' => 'statuslabels'], function () {


        Route::get('{id}/assetlist',
            [ 'as' => 'api.statuslabels.assets', 'uses' => 'StatuslabelsController@assets' ]);

        Route::get('{id}/deployable',
            [ 'as' => 'api.statuslabels.deployable', 'uses' => 'StatuslabelsController@checkIfDeployable' ]);



        // Pie chart for dashboard
        Route::get('assets', [ 'as' => 'api.statuslabels.assets.bytype', 'uses' => 'StatuslabelsController@getAssetCountByStatuslabel' ]);

    });


    Route::resource('statuslabels', 'StatuslabelsController',
        ['names' =>
            [
                'index' => 'api.statuslabels.index',
                'create' => 'api.statuslabels.create',
                'destroy' => 'api.statuslabels.destroy'
            ],
            'parameters' =>
                ['statuslabel' => 'statuslabel_id']
        ]
    );





    Route::resource('consumables', 'ConsumablesController',
        ['names' =>
            [
                'index' => 'api.consumables.index',
                'create' => 'api.consumables.create',
                'destroy' => 'api.consumables.destroy'
            ],
            'parameters' =>
                ['consumable' => 'consumable_id']
        ]
    );

    Route::resource('manufacturers', 'ManufacturersController',
        ['names' =>
            [
                'index' => 'api.manufacturers.index',
                'show' => 'api.manufacturers.show',
                'update' => 'api.manufacturers.update',
                'store' => 'api.manufacturers.store',
                'destroy' => 'api.manufacturers.destroy'
            ],
            'except' => ['edit'],
            'parameters' => ['manufacturer' => 'manufacturer_id']
        ]
    );


    Route::resource('accessories', 'AccessoriesController',
        ['names' =>
            [
                'index' => 'api.accessories.index',
                'create' => 'api.accessories.create',
                'destroy' => 'api.accessories.destroy'
            ],
            'parameters' =>
                ['accessory' => 'accessory_id']
        ]
    );




    /*---Hardware API---*/
    Route::post('hardware/import', [ 'as' => 'api.assets.importFile', 'uses'=> 'AssetsController@postAPIImportUpload']);

    Route::match(['DELETE'], 'hardware/{id}', ['uses' => 'AssetsController@destroy','as' => 'api.assets.destroy']);


    Route::resource('hardware', 'AssetsController',
        ['names' =>
            [
                'index' => 'api.assets.index',
                'create' => 'api.assets.create',
                'destroy' => 'api.assets.destroy'
            ],
         'parameters' =>
             ['asset' => 'asset_id']
          ]);


    /*---Accessories API---*/
    Route::group([ 'prefix' => 'accessories' ], function () {

        Route::get('list', [ 'as' => 'api.accessories.list', 'uses' => 'AccessoriesController@getDatatable' ]);
        Route::get(
            '{accessoryID}/view',
            [ 'as' => 'api.accessories.view', 'uses' => 'AccessoriesController@getDataView' ]
        );
    });



    /*---Locations API---*/
    Route::group(array('prefix'=>'locations'), function () {

        Route::get('{locationID}/users', array('as'=>'api.locations.viewusers', 'uses'=>'LocationsController@getDataViewUsers'));
        Route::get('{locationID}/assets', array('as'=>'api.locations.viewassets', 'uses'=>'LocationsController@getDataViewAssets'));

        // Do we actually still need this, now that we have an API?
        Route::get('{id}/check',
            [ 'as' => 'api.locations.check', 'uses' => 'LocationsController@show' ]);

    });


    /*---Suppliers API---*/
    Route::group(array('prefix'=>'suppliers'), function () {
        Route::get('list', array('as'=>'api.suppliers.list', 'uses'=>'SuppliersController@getDatatable'));
    });

    /*---Users API---*/
    Route::group([ 'prefix' => 'users' ], function () {
        Route::post('/', [ 'as' => 'api.users.store', 'uses' => 'UsersController@store' ]);
        Route::post('two_factor_reset', [ 'as' => 'api.users.two_factor_reset', 'uses' => 'UsersController@postTwoFactorReset' ]);
        Route::get('list/{status?}', [ 'as' => 'api.users.list', 'uses' => 'UsersController@getDatatable' ]);
        Route::get('{userId}/assets', [ 'as' => 'api.users.assetlist', 'uses' => 'UsersController@getAssetList' ]);
        Route::post('{userId}/upload', [ 'as' => 'upload/user', 'uses' => 'UsersController@postUpload' ]);
    });




    Route::group([ 'prefix' => 'fields' ], function () {

        Route::post(
            'fieldsets/{id}/order',
            [ 'as' => 'api.customfields.order', 'uses' => 'CustomFieldsController@postReorder' ]
        );

    });



});


