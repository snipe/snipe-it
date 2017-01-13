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

Route::group(['prefix' => 'v1'], function () {

    Route::resource('companies', '\App\Http\Controllers\Api\CompaniesController',
        [
            'parameters' =>
                ['company' => 'company_id']
            ]

    );


    Route::resource('components', '\App\Http\Controllers\Api\ComponentsController',
        ['names' =>
            [
                'index' => 'api.components.index',
                'create' => 'api.components.create',
                'destroy' => 'api.components.destroy'
            ],
            'parameters' =>
                ['component' => 'component_id']
        ]
    );


    Route::resource('suppliers', '\App\Http\Controllers\Api\SuppliersController',
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

    Route::resource('users', '\App\Http\Controllers\Api\UsersController',
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

    Route::resource('settings', '\App\Http\Controllers\Api\SettingsController',
        ['names' =>
            [
                'index' => 'api.settings.index',
                'create' => 'api.settings.create'
            ],
            'parameters' =>
                ['setting' => 'setting_id']
        ]
    );

    Route::resource('statuslabels', '\App\Http\Controllers\Api\StatuslabelsController',
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

    Route::resource('consumables', '\App\Http\Controllers\Api\ConsumablesController',
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

    Route::resource('manufacturers', '\App\Http\Controllers\Api\ManufacturersController',
        ['names' =>
            [
                'index' => 'api.manufacturers.index',
                'create' => 'api.manufacturers.create',
                'destroy' => 'api.manufacturers.destroy'
            ],
            'parameters' =>
                ['manufacturer' => 'manufacturer_id']
        ]
    );


    Route::resource('accessories', '\App\Http\Controllers\Api\AccessoriesController',
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

    Route::resource('locations', '\App\Http\Controllers\Api\LocationsController',
        ['names' =>
            [
                'index' => 'api.locations.index',
                'create' => 'api.locations.create',
                'destroy' => 'api.locations.destroy'
            ],
            'parameters' =>
                ['locations' => 'location_id']
        ]
    );



    /*---Hardware API---*/
    Route::post('hardware/import', [ 'as' => 'api.assets.importFile', 'uses'=> 'AssetsController@postAPIImportUpload']);

    Route::match(['DELETE'], 'hardware/{id}', ['uses' => '\App\Http\Controllers\Api\AssetsController@destroy','as' => 'api.assets.destroy']);


    Route::resource('hardware', '\App\Http\Controllers\Api\AssetsController',
        ['names' =>
            [
                'index' => 'api.assets.index',
                'create' => 'api.assets.create',
                'destroy' => 'api.assets.destroy'
            ],
         'parameters' =>
             ['asset' => 'asset_id']
          ]);








    /*---Status Label API---*/
    Route::group([ 'prefix' => 'statuslabels' ,'middleware' => ['authorize:admin']], function () {

        Route::resource('statuslabels', 'StatuslabelsController', [
            'parameters' => ['statuslabel' => 'statuslabel_id']
        ]);

        Route::get('{statuslabelId}/deployable', function ($statuslabelId) {

            $statuslabel = Statuslabel::find($statuslabelId);
            if (( $statuslabel->deployable == '1' ) && ( $statuslabel->pending != '1' )
                && ( $statuslabel->archived != '1' )
            ) {
                return '1';
            } else {
                return '0';
            }

        });

        Route::get('list', [ 'as' => 'api.statuslabels.list', 'uses' => 'StatuslabelsController@getDatatable' ]);
        Route::get('assets', [ 'as' => 'api.statuslabels.assets', 'uses' => 'StatuslabelsController@getAssetCountByStatuslabel' ]);

    });

    /*---Accessories API---*/
    Route::group([ 'prefix' => 'accessories' ], function () {

        Route::get('list', [ 'as' => 'api.accessories.list', 'uses' => 'AccessoriesController@getDatatable' ]);
        Route::get(
            '{accessoryID}/view',
            [ 'as' => 'api.accessories.view', 'uses' => 'AccessoriesController@getDataView' ]
        );
    });

    /*---Consumables API---*/
    Route::group(array('prefix'=>'consumables'), function () {
        Route::get('list', array('as'=>'api.consumables.list', 'uses'=>'ConsumablesController@getDatatable'));
        Route::get('{consumableID}/view', array('as'=>'api.consumables.view', 'uses'=>'ConsumablesController@getDataView'));
    });

    /*---Components API---*/
    Route::group(array('prefix'=>'components'), function () {
        Route::get('list', array('as'=>'api.components.list', 'uses'=>'ComponentsController@getDatatable'));
        Route::get('{componentID}/view', array('as'=>'api.components.view', 'uses'=>'ComponentsController@getDataView'));
    });

    /*---Locations API---*/
    Route::group(array('prefix'=>'locations'), function () {
        Route::get('list', array('as'=>'api.locations.list', 'uses'=>'LocationsController@getDatatable'));
        Route::get('{locationID}/view', array('as'=>'api.locations.view', 'uses'=>'LocationsController@getDataView'));
        Route::get('{locationID}/users', array('as'=>'api.locations.viewusers', 'uses'=>'LocationsController@getDataViewUsers'));
        Route::get('{locationID}/assets', array('as'=>'api.locations.viewassets', 'uses'=>'LocationsController@getDataViewAssets'));
    });

    /*---Depreciations API---*/
    Route::group(array('prefix'=>'depreciations'), function () {
        Route::get('list', array('as'=>'api.depreciations.list', 'uses'=>'DepreciationsController@getDatatable'));
        Route::get('{$depreciationID}/view', array('as'=>'api.depreciations.view', 'uses'=>'DepreciationsController@getDataView'));
    });

    /*---Manufacturers API---*/
    Route::group(array('prefix'=>'manufacturers'), function () {
        Route::get('list', array('as'=>'api.manufacturers.list', 'uses'=>'ManufacturersController@getDatatable'));
        Route::get('{manufacturerID}/view/{itemtype}', array('as'=>'api.manufacturers.view', 'uses'=>'ManufacturersController@getDataView'));
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

    /*---Groups API---*/
    Route::group([ 'prefix' => 'groups' ], function () {
        Route::get('list', [ 'as' => 'api.groups.list', 'uses' => 'GroupsController@getDatatable' ]);
    });

    /*---Licenses API---*/
    Route::group([ 'prefix' => 'licenses' ], function () {

        Route::get('list', [ 'as' => 'api.licenses.list', 'uses' => 'LicensesController@getDatatable' ]);
    });

    /*---Locations API---*/
    Route::group([ 'prefix' => 'locations' ], function () {

        Route::resource('/', 'LocationsController');
        Route::get('{locationID}/check', function ($locationID) {

            $location = Location::find($locationID);

            return $location;
        });
    });

    /*---Improvements API---*/
    Route::group([ 'prefix' => 'asset_maintenances' ], function () {

        Route::get(
            'list',
            [ 'as' => 'api.asset_maintenances.list', 'uses' => 'AssetMaintenancesController@getDatatable' ]
        );
    });

    /*---Models API---*/
    Route::group([ 'prefix' => 'models' ], function () {
        Route::resource('/', 'AssetModelsController');
        Route::get('/{status?}', [ 'as' => 'api.models.index', 'uses' => 'AssetModelsController@getDatatable' ]);
        Route::get('{modelID}/view', [ 'as' => 'api.models.view', 'uses' => 'AssetModelsController@getDataView' ]);

    });



    /*--- Categories API---*/
    Route::group([ 'prefix' => 'categories' ], function () {

        Route::get('list', [ 'as' => 'api.categories.list', 'uses' => 'CategoriesController@getDatatable' ]);
        Route::get(
            '{categoryID}/asset/view',
            [ 'as' => 'api.categories.asset.view', 'uses' => 'CategoriesController@getDataViewAssets' ]
        );
        Route::get(
            '{categoryID}/accessory/view',
            [ 'as' => 'api.categories.accessory.view', 'uses' => 'CategoriesController@getDataViewAccessories' ]
        );
        Route::get(
            '{categoryID}/consumable/view',
            [ 'as' => 'api.categories.consumable.view', 'uses' => 'CategoriesController@getDataViewConsumables' ]
        );
        Route::get(
            '{categoryID}/component/view',
            [ 'as' => 'api.categories.component.view', 'uses' => 'CategoriesController@getDataViewComponent' ]
        );
    });

    /*-- Suppliers API (mostly for creating new ones in-line while creating an asset) --*/
    Route::group([ 'prefix' => 'suppliers' ], function () {

        Route::resource('/', 'SuppliersController');
    });

    /*-- Custom fields API --*/
    Route::group([ 'prefix' => 'custom_fields' ], function () {
        Route::post(
            '{fieldsetID}/order',
            [ 'as' => 'api.customfields.order', 'uses' => 'CustomFieldsController@postReorder' ]
        );
    });


});

Route::get('test', function(){
    return 'returned string from test route';
});


