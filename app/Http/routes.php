<?php
use App\Models\CheckoutRequest;
use App\Models\Location;
use App\Models\Statuslabel;

/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
*/
Route::group([ 'prefix' => 'api', 'middleware' => 'auth' ], function () {

    /*---Hardware API---*/
    Route::group([ 'prefix' => 'hardware','middleware' => ['web','auth','authorize:assets.view']], function () {

        Route::get('list/{status?}', [ 'as' => 'api.hardware.list', 'uses' => 'AssetsController@getDatatable' ]);

        Route::post('import', 'AssetsController@postAPIImportUpload');
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

        Route::resource('/', 'AssetModelsController');
        Route::get('list/{status?}', [ 'as' => 'api.models.list', 'uses' => 'AssetModelsController@getDatatable' ]);
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

/*
|--------------------------------------------------------------------------
| Asset Routes
|--------------------------------------------------------------------------
|
| Register all the asset routes.
|
*/

Route::group(
    [ 'prefix' => 'hardware',
    'middleware' => ['web',
    'auth']],
    function () {

        Route::get('history', [
            'as' => 'asset.import-history',
            'middleware' => 'authorize:assets.checkout',
            'uses' => 'AssetsController@getImportHistory'
        ]);

        Route::post('history', [
            'as' => 'asset.process-import-history',
            'middleware' => 'authorize:assets.checkout',
            'uses' => 'AssetsController@postImportHistory'
        ]);


        Route::get('create/{model?}', [
                'as'   => 'create/hardware',
                'middleware' => 'authorize:assets.create',
                'uses' => 'AssetsController@getCreate'
            ]);

        Route::post('create', [
                'as'   => 'savenew/hardware',
                'middleware' => 'authorize:assets.create',
                'uses' => 'AssetsController@postCreate'
            ]);

        Route::get('{assetId}/edit', [
                'as'   => 'update/hardware',
                'middleware' => 'authorize:assets.edit',
                'uses' => 'AssetsController@getEdit'
            ]);
        Route::get('/bytag', [
            'as'   => 'findbytag/hardware',
            'middleware' => 'authorize:assets.view',
            'uses' => 'AssetsController@getAssetByTag'
        ]);

        Route::get('{assetId}/clone', [
            'as' => 'clone/hardware',
            'middleware' => 'authorize:assets.create',
            'uses' => 'AssetsController@getClone'
        ]);

        Route::post('{assetId}/clone', 'AssetsController@postCreate');
        Route::get('{assetId}/delete', [
            'as' => 'delete/hardware',
            'middleware' => 'authorize:assets.delete',
            'uses' => 'AssetsController@getDelete'
        ]);
        Route::get('{assetId}/checkout', [
            'as' => 'checkout/hardware',
            'middleware' => 'authorize:assets.checkout',
            'uses' => 'AssetsController@getCheckout'
        ]);
        Route::post('{assetId}/checkout', [
            'as' => 'checkout/hardware',
            'middleware' => 'authorize:assets.checkout',
            'uses' => 'AssetsController@postCheckout'
        ]);
        Route::get('{assetId}/checkin/{backto?}', [
            'as' => 'checkin/hardware',
            'middleware' => 'authorize:assets.checkin',
            'uses' => 'AssetsController@getCheckin'
        ]);

        Route::post('{assetId}/checkin/{backto?}', [
            'as' => 'checkin/hardware',
            'middleware' => 'authorize:assets.checkin',
            'uses' => 'AssetsController@postCheckin'
        ]);
        Route::get('{assetId}/view', [
            'as' => 'view/hardware',
            'middleware' => ['authorize:assets.view'],
            'uses' => 'AssetsController@getView'
        ]);
        Route::get('{assetId}/qr-view', [ 'as' => 'qr-view/hardware', 'uses' => 'AssetsController@getView' ]);
        Route::get('{assetId}/qr_code', [ 'as' => 'qr_code/hardware', 'uses' => 'AssetsController@getQrCode' ]);
        Route::get('{assetId}/barcode', [ 'as' => 'barcode/hardware', 'uses' => 'AssetsController@getBarCode' ]);
        Route::get('{assetId}/restore', [
            'as' => 'restore/hardware',
            'middleware' => 'authorize:assets.delete',
            'uses' => 'AssetsController@getRestore'
        ]);
        Route::post('{assetId}/upload', [
            'as' => 'upload/asset',
            'middleware' => 'authorize:assets.edit',
            'uses' => 'AssetsController@postUpload'
        ]);

        Route::get('{assetId}/deletefile/{fileId}', [
            'as' => 'delete/assetfile',
            'middleware' => 'authorize:assets.edit',
            'uses' => 'AssetsController@getDeleteFile'
        ]);

        Route::get('{assetId}/showfile/{fileId}', [
            'as' => 'show/assetfile',
            'middleware' => 'authorize:assets.view',
            'uses' => 'AssetsController@displayFile'
        ]);

        Route::get('import/delete-import/{filename}',  [
                'as' => 'assets/import/delete-file',
                'middleware' => 'authorize:assets.create',
                'uses' => 'AssetsController@getDeleteImportFile'
        ]);

        Route::post( 'import/process/', [ 'as' => 'assets/import/process-file',
                'middleware' => 'authorize:assets.create',
                'uses' => 'AssetsController@postProcessImportFile'
        ]);
        Route::get( 'import/delete/{filename}', [ 'as' => 'assets/import/delete-file',
                'middleware' => 'authorize:assets.create', // TODO What permissions should this require?
                'uses' => 'AssetsController@getDeleteImportFile'
        ]);

        Route::get('import',[
                'as' => 'assets/import',
                'middleware' => 'authorize:assets.create',
                'uses' => 'AssetsController@getImportUpload'
        ]);


        Route::post('{assetId}/edit',[
            'as' => 'assets/import',
            'middleware' => 'authorize:assets.edit',
            'uses' => 'AssetsController@postEdit'
        ]);

        Route::post(
            'bulkedit',
            [
                'as'   => 'hardware/bulkedit',
                'middleware' => 'authorize:assets.edit',
                'uses' => 'AssetsController@postBulkEdit'
            ]
        );
        Route::post(
            'bulkdelete',
            [
                'as'   => 'hardware/bulkdelete',
                'middleware' => 'authorize:assets.delete',
                'uses' => 'AssetsController@postBulkDelete'
            ]
        );
        Route::post(
            'bulksave',
            [
                'as'   => 'hardware/bulksave',
                'middleware' => 'authorize:assets.edit',
                'uses' => 'AssetsController@postBulkSave'
            ]
        );

        # Bulk checkout / checkin
         Route::get( 'bulkcheckout',  [
                 'as' => 'hardware/bulkcheckout',
                 'middleware' => 'authorize:assets.checkout',
                 'uses' => 'AssetsController@getBulkCheckout'
         ]);
        Route::post( 'bulkcheckout',  [
            'as' => 'hardware/bulkcheckout',
            'middleware' => 'authorize:assets.checkout',
            'uses' => 'AssetsController@postBulkCheckout'
        ]);

        # Asset Model Management
        Route::group([ 'prefix' => 'models', 'middleware' => ['auth'] ], function () {

            Route::get('create', [ 'as' => 'create/model', 'uses' => 'AssetModelsController@getCreate', 'middleware' => ['authorize:superuser'] ]);
            Route::post('create', 'AssetModelsController@postCreate');
            Route::get('{modelId}/edit', [ 'as' => 'update/model', 'uses' => 'AssetModelsController@getEdit' , 'middleware' => ['authorize:superuser']]);
            Route::post('{modelId}/edit', [ 'uses' => 'AssetModelsController@postEdit', 'middleware' => ['authorize:superuser']]);
            Route::get('{modelId}/clone', [ 'as' => 'clone/model', 'uses' => 'AssetModelsController@getClone' ]);
            Route::post('{modelId}/clone', 'AssetModelsController@postCreate');
            Route::get('{modelId}/delete', [ 'as' => 'delete/model', 'uses' => 'AssetModelsController@getDelete', 'middleware' => ['authorize:superuser'] ]);
            Route::get('{modelId}/view', [ 'as' => 'view/model', 'uses' => 'AssetModelsController@getView' ]);
            Route::get('{modelID}/restore', [ 'as' => 'restore/model', 'uses' => 'AssetModelsController@getRestore', 'middleware' => ['authorize:superuser'] ]);
            Route::get('{modelId}/custom_fields', ['as' => 'custom_fields/model','uses' => 'AssetModelsController@getCustomFields']);
            Route::get('/', [ 'as' => 'models', 'uses' => 'AssetModelsController@getIndex' ,'middleware' => ['authorize:superuser'] ]);
        });

        Route::get('/', [
                'as'   => 'hardware',
                'middleware' => 'authorize:assets.view',
                'uses' => 'AssetsController@getIndex'
            ]);

    }
);

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
    # Licenses
    Route::group([ 'prefix' => 'licenses', 'middleware'=>'authorize:licenses.view' ], function () {

        Route::get('create', [ 'as' => 'create/licenses', 'middleware' => 'authorize:licenses.create','uses' => 'LicensesController@getCreate' ]);
        Route::post('create', [ 'as' => 'create/licenses', 'middleware' => 'authorize:licenses.create','uses' => 'LicensesController@postCreate' ]);
        Route::get('{licenseId}/edit', [ 'as' => 'update/license', 'middleware' => 'authorize:licenses.edit', 'uses' => 'LicensesController@getEdit' ]);
        Route::post('{licenseId}/edit', [ 'as' => 'update/license', 'middleware' => 'authorize:licenses.edit', 'uses' => 'LicensesController@postEdit' ]);
        Route::get('{licenseId}/clone', [ 'as' => 'clone/license', 'middleware' => 'authorize:licenses.create', 'uses' => 'LicensesController@getClone' ]);
        Route::post('{licenseId}/clone', [ 'as' => 'clone/license', 'middleware' => 'authorize:licenses.create', 'uses' => 'LicensesController@postCreate' ]);
        Route::get('{licenseId}/delete', [ 'as' => 'delete/license', 'middleware' => 'authorize:licenses.delete', 'uses' => 'LicensesController@getDelete' ]);
        Route::get('{licenseId}/freecheckout', [
            'as' => 'freecheckout/license',
            'middleware' => 'authorize:licenses.checkout',
            'uses' => 'LicensesController@getFreeLicense'
        ]);
        Route::get(
            '{licenseId}/checkout',
            [ 'as' => 'checkout/license', 'middleware' => 'authorize:licenses.checkout','uses' => 'LicensesController@getCheckout' ]
        );
        Route::post(
            '{licenseId}/checkout',
            [ 'as' => 'checkout/license', 'middleware' => 'authorize:licenses.checkout','uses' => 'LicensesController@postCheckout' ]
        );
        Route::get('{licenseId}/checkin/{backto?}', [
            'as' => 'checkin/license',
            'middleware' => 'authorize:licenses.checkin',
            'uses' => 'LicensesController@getCheckin'
        ]);

        Route::post('{licenseId}/checkin/{backto?}', [
            'as' => 'checkin/license',
            'middleware' => 'authorize:licenses.checkin',
            'uses' => 'LicensesController@postCheckin'
        ]);

        Route::get('{licenseId}/view', [
            'as' => 'view/license',
            'middleware' => 'authorize:licenses.view',
            'uses' => 'LicensesController@getView'
        ]);

        Route::post(
            '{licenseId}/upload',
            [ 'as' => 'upload/license', 'middleware' => 'authorize:licenses.edit','uses' => 'LicensesController@postUpload' ]
        );
        Route::get(
            '{licenseId}/deletefile/{fileId}',
            [ 'as' => 'delete/licensefile', 'middleware' => 'authorize:licenses.edit', 'uses' => 'LicensesController@getDeleteFile' ]
        );
        Route::get(
            '{licenseId}/showfile/{fileId}',
            [ 'as' => 'show/licensefile', 'middleware' => 'authorize:licenses.view','uses' => 'LicensesController@displayFile' ]
        );
        Route::get('/', [ 'as' => 'licenses', 'middleware' => 'authorize:licenses.view','uses' => 'LicensesController@getIndex' ]);
    });

    # Asset Maintenances
    Route::group([ 'prefix' => 'asset_maintenances', 'middleware'=>'authorize:assets.view'  ], function () {

        Route::get('create/{assetId?}',
            [ 'as' => 'create/asset_maintenances',
                'middleware' => 'authorize:assets.edit',
                'uses' => 'AssetMaintenancesController@getCreate'
            ]);

        Route::post('create/{assetId?}',
            [ 'as' => 'create/asset_maintenances.save',
                'middleware' => 'authorize:assets.edit',
                'uses' => 'AssetMaintenancesController@postCreate'
            ]);

        Route::get('{assetMaintenanceId}/edit',
            [ 'as' => 'update/asset_maintenance',
                'middleware' => 'authorize:assets.edit',
                'uses' => 'AssetMaintenancesController@getEdit'
            ]);

        Route::post('{assetMaintenanceId}/edit',
            [ 'as' => 'update/asset_maintenance.save',
                'middleware' => 'authorize:assets.edit',
                'uses' => 'AssetMaintenancesController@postEdit'
            ]);

        Route::get(
            '{assetMaintenanceId}/delete',
            [ 'as' => 'delete/asset_maintenance', 'uses' => 'AssetMaintenancesController@getDelete' ]
        );
        Route::get(
            '{assetMaintenanceId}/view',
            [ 'as' => 'view/asset_maintenance', 'uses' => 'AssetMaintenancesController@getView' ]
        );

        Route::get('/', [ 'as' => 'asset_maintenances', 'uses' => 'AssetMaintenancesController@getIndex' ]);
    });

    # Accessories
    Route::group([ 'prefix' => 'accessories', 'middleware'=>'authorize:accessories.view'  ], function () {

        Route::get('create', [ 'as' => 'create/accessory', 'middleware' => 'authorize:accessories.create','uses' => 'AccessoriesController@getCreate' ]);
        Route::post('create', 'AccessoriesController@postCreate');
        Route::get(
            '{accessoryID}/edit',
            [ 'as' => 'update/accessory', 'middleware' => 'authorize:accessories.edit','uses' => 'AccessoriesController@getEdit' ]
        );
        Route::post('{accessoryID}/edit', 'AccessoriesController@postEdit');
        Route::get(
            '{accessoryID}/delete',
            [ 'as' => 'delete/accessory', 'middleware' => 'authorize:accessories.delete','uses' => 'AccessoriesController@getDelete' ]
        );
        Route::get('{accessoryID}/view', [ 'as' => 'view/accessory', 'middleware' => 'authorize:accessories.view','uses' => 'AccessoriesController@getView' ]);
        Route::get(
            '{accessoryID}/checkout',
            [ 'as' => 'checkout/accessory', 'middleware' => 'authorize:accessories.checkout','uses' => 'AccessoriesController@getCheckout' ]
        );
        Route::post(
            '{accessoryID}/checkout',
            [ 'as' => 'checkout/accessory', 'middleware' => 'authorize:accessories.checkout','uses' => 'AccessoriesController@postCheckout' ]
        );

        Route::get(
            '{accessoryID}/checkin/{backto?}',
            [ 'as' => 'checkin/accessory', 'middleware' => 'authorize:accessories.checkin','uses' => 'AccessoriesController@getCheckin' ]
        );
        Route::post(
            '{accessoryID}/checkin/{backto?}',
            [ 'as' => 'checkin/accessory', 'middleware' => 'authorize:accessories.checkin','uses' => 'AccessoriesController@postCheckin' ]
        );

        Route::get('/', [ 'as' => 'accessories', 'middleware'=>'authorize:accessories.view', 'uses' => 'AccessoriesController@getIndex' ]);
    });

    # Consumables
    Route::group([ 'prefix' => 'consumables', 'middleware'=>'authorize:consumables.view'  ], function () {

        Route::get('create', [ 'as' => 'create/consumable','middleware'=>'authorize:consumables.create', 'uses' => 'ConsumablesController@getCreate' ]);
        Route::post('create', [ 'as' => 'create/consumable','middleware'=>'authorize:consumables.create', 'uses' => 'ConsumablesController@postCreate' ]);
        Route::get(
            '{consumableID}/edit',
            [ 'as' => 'update/consumable', 'middleware'=>'authorize:consumables.edit', 'uses' => 'ConsumablesController@getEdit' ]
        );
        Route::post(
            '{consumableID}/edit',
            [ 'as' => 'update/consumable', 'middleware'=>'authorize:consumables.edit', 'uses' => 'ConsumablesController@postEdit' ]
        );
        Route::get(
            '{consumableID}/delete',
            [ 'as' => 'delete/consumable',  'middleware'=>'authorize:consumables.delete','uses' => 'ConsumablesController@getDelete' ]
        );
        Route::get(
            '{consumableID}/view',
            [ 'as' => 'view/consumable',  'middleware'=>'authorize:consumables.view','uses' => 'ConsumablesController@getView' ]
        );
        Route::get(
            '{consumableID}/checkout',
            [ 'as' => 'checkout/consumable',  'middleware'=>'authorize:consumables.checkout','uses' => 'ConsumablesController@getCheckout' ]
        );
        Route::post(
            '{consumableID}/checkout',
            [ 'as' => 'checkout/consumable',  'middleware'=>'authorize:consumables.checkout','uses' => 'ConsumablesController@postCheckout' ]
        );
        Route::get('/', [ 'as' => 'consumables', 'middleware'=>'authorize:consumables.view','uses' => 'ConsumablesController@getIndex' ]);
    });

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

        # Companies
        Route::group([ 'prefix' => 'companies' ], function () {

            Route::get('{companyId}/edit', ['as' => 'update/company', 'uses' => 'CompaniesController@getEdit']);
            Route::get('create', ['as' => 'create/company', 'uses' => 'CompaniesController@getCreate']);
            Route::get('/', ['as' => 'companies', 'uses' => 'CompaniesController@getIndex']);

            Route::post('{companyId}/delete', ['as' => 'delete/company', 'uses' => 'CompaniesController@postDelete']);
            Route::post('{companyId}/edit', 'CompaniesController@postEdit');
            Route::post('create', 'CompaniesController@postCreate');
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

        # Categories
        Route::group([ 'prefix' => 'categories' ], function () {

            Route::get('create', [ 'as' => 'create/category', 'uses' => 'CategoriesController@getCreate' ]);
            Route::post('create', 'CategoriesController@postCreate');
            Route::get(
                '{categoryId}/edit',
                [ 'as' => 'update/category', 'uses' => 'CategoriesController@getEdit' ]
            );
            Route::post('{categoryId}/edit', 'CategoriesController@postEdit');
            Route::get(
                '{categoryId}/delete',
                [ 'as' => 'delete/category', 'uses' => 'CategoriesController@getDelete' ]
            );
            Route::get(
                '{categoryId}/view',
                [ 'as' => 'view/category', 'uses' => 'CategoriesController@getView' ]
            );
            Route::get('/', [ 'as' => 'categories', 'uses' => 'CategoriesController@getIndex' ]);
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
    Route::get('custom_fields/create-field', ['uses' =>'CustomFieldsController@createField','as' => 'admin.custom_fields.create-field']);
    Route::post('custom_fields/create-field', ['uses' => 'CustomFieldsController@storeField','as' => 'admin.custom_fields.store-field']);
    Route::post('custom_fields/{id}/associate', ['uses' => 'CustomFieldsController@associate','as' => 'admin.custom_fields.associate']);
    Route::get('custom_fields/{field_id}/{fieldset_id}/disassociate', ['uses' => 'CustomFieldsController@deleteFieldFromFieldset','as' => 'admin.custom_fields.disassociate']);
    Route::match(['DELETE'], 'custom_fields/delete-field/{id}', ['uses' => 'CustomFieldsController@deleteField','as' => 'admin.custom_fields.delete-field']);
    Route::resource('custom_fields', 'CustomFieldsController');

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
        Route::get('{userId}/delete', [ 'as' => 'delete/user', 'uses' => 'UsersController@getDelete', 'middleware' => ['authorize:users.delete']  ]);
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
        'uses' => 'Auth\AuthController@getTwoFactorEnroll' ]
);

Route::get(
    'two-factor',
    [
        'as' => 'two-factor',
        'middleware' => ['web'],
        'uses' => 'Auth\AuthController@getTwoFactorAuth' ]
);

Route::post(
    'two-factor',
    [
        'as' => 'two-factor',
        'middleware' => ['web'],
        'uses' => 'Auth\AuthController@postTwoFactorAuth' ]
);

Route::get(
    '/',
    [
    'as' => 'home',
    'middleware' => ['web', 'auth'],
    'uses' => 'DashboardController@getIndex' ]
);



Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get(
        'login',
        [
            'as' => 'login',
            'middleware' => ['web'],
            'uses' => 'Auth\AuthController@showLoginForm' ]
    );
    Route::get(
        'logout',
        [
            'as' => 'logout',
            'uses' => 'Auth\AuthController@logout' ]
    );

});

Route::get('home', function () {
    return redirect('/');
});
