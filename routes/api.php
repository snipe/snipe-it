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

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {

    /*---Hardware API---*/
    Route::group([ 'prefix' => 'hardware','middleware' => ['web','auth']], function () {

        Route::get('list/{status?}', [ 'as' => 'api.hardware.list', 'uses' => 'AssetsController@getDatatable' ]);

        Route::post('import', [ 'as' => 'api.hardware.importFile', 'uses'=> 'AssetsController@postAPIImportUpload']);
    });

    /*---Status Label API---*/
    Route::group([ 'prefix' => 'statuslabels' ,'middleware' => ['web','auth','authorize:admin']], function () {

        Route::resource('/', 'StatuslabelsController');
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
