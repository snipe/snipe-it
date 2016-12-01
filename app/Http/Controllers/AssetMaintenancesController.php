<?php
namespace App\Http\Controllers;

use App\Models\AssetMaintenance;
use Carbon\Carbon;
use App\Models\Company;
use DB;
use Input;
use Lang;
use Log;
use Mail;
use Redirect;
use Response;
use Slack;
use Str;
use App\Models\Supplier;
use TCPDF;
use Validator;
use View;
use App\Models\Setting;
use App\Models\Asset;
use App\Helpers\Helper;
use Auth;
use Gate;

/**
 * This controller handles all actions related to Asset Maintenance for
 * the Snipe-IT Asset Management application.
 *
 * @version    v2.0
 */
class AssetMaintenancesController extends Controller
{

    /**
    * Checks for permissions for this action.
    *
    * @todo This should be replaced with middleware and/or policies
    * @author  Vincent Sposato <vincent.sposato@gmail.com>
    * @version v1.0
    * @since [v1.8]
    * @return View
    */
    private static function getInsufficientPermissionsRedirect()
    {
        return redirect()->route('asset_maintenances')
          ->with('error', trans('general.insufficient_permissions'));
    }

    /**
    *  Returns a view that invokes the ajax tables which actually contains
    * the content for the asset maintenances listing, which is generated in getDatatable.
    *
    * @todo This should be replaced with middleware and/or policies
    * @see AssetMaintenancesController::getDatatable() method that generates the JSON response
    * @author  Vincent Sposato <vincent.sposato@gmail.com>
    * @version v1.0
    * @since [v1.8]
    * @return View
    */
    public function getIndex()
    {

        return View::make('asset_maintenances/index');
    }


    /**
    *  Generates the JSON response for asset maintenances listing view.
    *
    * @see AssetMaintenancesController::getIndex() method that generates view
    * @author  Vincent Sposato <vincent.sposato@gmail.com>
    * @version v1.0
    * @since [v1.8]
    * @return String JSON
    */
    public function getDatatable()
    {
        $maintenances = AssetMaintenance::with('asset', 'supplier', 'asset.company','admin');

        if (Input::has('search')) {
            $maintenances = $maintenances->TextSearch(e(Input::get('search')));
        }




        if (Input::has('offset')) {
            $offset = e(Input::get('offset'));
        } else {
            $offset = 0;
        }

        if (Input::has('limit')) {
            $limit = e(Input::get('limit'));
        } else {
            $limit = 50;
        }



        $allowed_columns = ['id','title','asset_maintenance_time','asset_maintenance_type','cost','start_date','completion_date','notes','user_id'];
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array(Input::get('sort'), $allowed_columns) ? e(Input::get('sort')) : 'created_at';

        switch ($sort) {
            case 'user_id':
                $maintenances = $maintenances->OrderAdmin($order);
                break;
            default:
                $maintenances = $maintenances->orderBy($sort, $order);
                break;
        }

        $maintenancesCount = $maintenances->count();
        $maintenances = $maintenances->skip($offset)->take($limit)->get();

        $rows = array();
        $settings = Setting::getSettings();

        foreach ($maintenances as $maintenance) {
            $actions = '';
            if (Gate::allows('assets.edit')) {
                $actions .= '<nobr><a href="' . route('update/asset_maintenance',
                        $maintenance->id) . '" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="' . route('delete/asset_maintenance',
                        $maintenance->id) . '" data-content="' . trans('admin/asset_maintenances/message.delete.confirm') . '" data-title="' . trans('general.delete') . ' ' . htmlspecialchars($maintenance->title) . '?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a></nobr>';
            }

            if (($maintenance->cost) && (isset($maintenance->asset)) && ($maintenance->asset->assetloc) &&  ($maintenance->asset->assetloc->currency!='')) {
                $maintenance_cost = $maintenance->asset->assetloc->currency.$maintenance->cost;
            } else {
                $maintenance_cost = $settings->default_currency.$maintenance->cost;
            }
            
            $rows[] = array(
                'id'            => $maintenance->id,
                'asset_name'    =>  ($maintenance->asset) ? (string)link_to('/hardware/'.$maintenance->asset->id.'/view', $maintenance->asset->showAssetName()) : 'Deleted Asset' ,
                'title'         => $maintenance->title,
                'notes'         => $maintenance->notes,
                'supplier'      => ($maintenance->supplier) ? (string)link_to('/admin/settings/suppliers/'.$maintenance->supplier->id.'/view', $maintenance->supplier->name) : 'Deleted Supplier',
                'cost'          => $maintenance_cost,
                'asset_maintenance_type'          => e($maintenance->asset_maintenance_type),
                'start_date'         => $maintenance->start_date,
                'asset_maintenance_time'          => $maintenance->asset_maintenance_time,
                'completion_date'     => $maintenance->completion_date,
                'user_id'       => ($maintenance->admin) ? (string)link_to('/admin/users/'.$maintenance->admin->id.'/view', $maintenance->admin->fullName()) : '',
                'actions'       => $actions,
                'companyName'   => ($maintenance->asset->company) ? $maintenance->asset->company->name : ''
            );
        }

        $data = array('total' => $maintenancesCount, 'rows' => $rows);
        return $data;

    }

    /**
    *  Returns a form view to create a new asset maintenance.
    *
    * @see AssetMaintenancesController::postCreate() method that stores the data
    * @author  Vincent Sposato <vincent.sposato@gmail.com>
    * @version v1.0
    * @since [v1.8]
    * @return mixed
    */
    public function getCreate($assetId = null)
    {
        // Prepare Asset Maintenance Type List
        $assetMaintenanceType = [
                                    '' => 'Select an asset maintenance type',
                                ] + AssetMaintenance::getImprovementOptions();
        // Mark the selected asset, if it came in
        $selectedAsset = $assetId;

        $assets = Helper::detailedAssetList();

        $supplier_list = Helper::suppliersList();

        // Render the view
        return View::make('asset_maintenances/edit')
                   ->with('asset_list', $assets)
                   ->with('selectedAsset', $selectedAsset)
                   ->with('supplier_list', $supplier_list)
                   ->with('assetMaintenanceType', $assetMaintenanceType)
                   ->with('item', new AssetMaintenance);
    }

    /**
    *  Validates and stores the new asset maintenance
    *
    * @see AssetMaintenancesController::getCreate() method for the form
    * @author  Vincent Sposato <vincent.sposato@gmail.com>
    * @version v1.0
    * @since [v1.8]
    * @return mixed
    */
    public function postCreate()
    {

        // get the POST data
        $new = Input::all();

        // create a new model instance
        $assetMaintenance = new AssetMaintenance();


        if (e(Input::get('supplier_id')) == '') {
            $assetMaintenance->supplier_id = null;
        } else {
            $assetMaintenance->supplier_id = e(Input::get('supplier_id'));
        }

        if (e(Input::get('is_warranty')) == '') {
            $assetMaintenance->is_warranty = 0;
        } else {
            $assetMaintenance->is_warranty = e(Input::get('is_warranty'));
        }

        if (e(Input::get('cost')) == '') {
            $assetMaintenance->cost = '';
        } else {
            $assetMaintenance->cost =  Helper::ParseFloat(e(Input::get('cost')));
        }

        if (e(Input::get('notes')) == '') {
            $assetMaintenance->notes = null;
        } else {
            $assetMaintenance->notes = e(Input::get('notes'));
        }

        $asset = Asset::find(e(Input::get('asset_id')));

        if (!Company::isCurrentUserHasAccess($asset)) {
            return static::getInsufficientPermissionsRedirect();
        }

        // Save the asset maintenance data
        $assetMaintenance->asset_id               = e(Input::get('asset_id'));
        $assetMaintenance->asset_maintenance_type = e(Input::get('asset_maintenance_type'));
        $assetMaintenance->title                  = e(Input::get('title'));
        $assetMaintenance->start_date             = e(Input::get('start_date'));
        $assetMaintenance->completion_date        = e(Input::get('completion_date'));
        $assetMaintenance->user_id                = Auth::user()->id;

        if (( $assetMaintenance->completion_date == "" )
            || ( $assetMaintenance->completion_date == "0000-00-00" )
        ) {
            $assetMaintenance->completion_date = null;
        }

        if (( $assetMaintenance->completion_date !== "" )
            && ( $assetMaintenance->completion_date !== "0000-00-00" )
            && ( $assetMaintenance->start_date !== "" )
            && ( $assetMaintenance->start_date !== "0000-00-00" )
        ) {
            $startDate                                = Carbon::parse($assetMaintenance->start_date);
            $completionDate                           = Carbon::parse($assetMaintenance->completion_date);
            $assetMaintenance->asset_maintenance_time = $completionDate->diffInDays($startDate);
        }

        // Was the asset maintenance created?
        if ($assetMaintenance->save()) {

            // Redirect to the new asset maintenance page
            return redirect()->to("admin/asset_maintenances")
                           ->with('success', trans('admin/asset_maintenances/message.create.success'));
        }

        return redirect()->back()->withInput()->withErrors($assetMaintenance->getErrors());




    }

    /**
    *  Returns a form view to edit a selected asset maintenance.
    *
    * @see AssetMaintenancesController::postEdit() method that stores the data
    * @author  Vincent Sposato <vincent.sposato@gmail.com>
    * @param int $assetMaintenanceId
    * @version v1.0
    * @since [v1.8]
    * @return mixed
    */
    public function getEdit($assetMaintenanceId = null)
    {
        // Check if the asset maintenance exists
        if (is_null($assetMaintenance = AssetMaintenance::find($assetMaintenanceId))) {
            // Redirect to the improvement management page
            return redirect()->to('admin/asset_maintenances')
                           ->with('error', trans('admin/asset_maintenances/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($assetMaintenance->asset)) {
            return static::getInsufficientPermissionsRedirect();
        }

        if ($assetMaintenance->completion_date == '0000-00-00') {
            $assetMaintenance->completion_date = null;
        }

        if ($assetMaintenance->start_date == '0000-00-00') {
            $assetMaintenance->start_date = null;
        }

        if ($assetMaintenance->cost == '0.00') {
            $assetMaintenance->cost = null;
        }

        // Prepare Improvement Type List
        $assetMaintenanceType = [
                                    '' => 'Select an improvement type',
                                ] + AssetMaintenance::getImprovementOptions();

        $assets = Company::scopeCompanyables(Asset::with('model','assignedUser')->get(), 'assets.company_id')->lists('detailed_name', 'id');
        // Get Supplier List
        $supplier_list = Helper::suppliersList();

        // Render the view
        return View::make('asset_maintenances/edit')
                   ->with('asset_list', $assets)
                   ->with('selectedAsset', null)
                   ->with('supplier_list', $supplier_list)
                   ->with('assetMaintenanceType', $assetMaintenanceType)
                   ->with('item', $assetMaintenance);

    }

    /**
    *  Validates and stores an update to an asset maintenance
    *
    * @see AssetMaintenancesController::postEdit() method that stores the data
    * @author  Vincent Sposato <vincent.sposato@gmail.com>
    * @param int $assetMaintenanceId
    * @version v1.0
    * @since [v1.8]
    * @return mixed
    */
    public function postEdit($assetMaintenanceId = null)
    {

        // get the POST data
        $new = Input::all();

        // Check if the asset maintenance exists
        if (is_null($assetMaintenance = AssetMaintenance::find($assetMaintenanceId))) {
            // Redirect to the asset maintenance management page
            return redirect()->to('admin/asset_maintenances')
                           ->with('error', trans('admin/asset_maintenances/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($assetMaintenance->asset)) {
            return static::getInsufficientPermissionsRedirect();
        }



        if (e(Input::get('supplier_id')) == '') {
            $assetMaintenance->supplier_id = null;
        } else {
            $assetMaintenance->supplier_id = e(Input::get('supplier_id'));
        }

        if (e(Input::get('is_warranty')) == '') {
            $assetMaintenance->is_warranty = 0;
        } else {
            $assetMaintenance->is_warranty = e(Input::get('is_warranty'));
        }

        if (e(Input::get('cost')) == '') {
            $assetMaintenance->cost = '';
        } else {
            $assetMaintenance->cost =  Helper::ParseFloat(e(Input::get('cost')));
        }

        if (e(Input::get('notes')) == '') {
            $assetMaintenance->notes = null;
        } else {
            $assetMaintenance->notes = e(Input::get('notes'));
        }

        $asset = Asset::find(e(Input::get('asset_id')));

        if (!Company::isCurrentUserHasAccess($asset)) {
            return static::getInsufficientPermissionsRedirect();
        }

        // Save the asset maintenance data
        $assetMaintenance->asset_id               = e(Input::get('asset_id'));
        $assetMaintenance->asset_maintenance_type = e(Input::get('asset_maintenance_type'));
        $assetMaintenance->title                  = e(Input::get('title'));
        $assetMaintenance->start_date             = e(Input::get('start_date'));
        $assetMaintenance->completion_date        = e(Input::get('completion_date'));

        if (( $assetMaintenance->completion_date == "" )
          || ( $assetMaintenance->completion_date == "0000-00-00" )
        ) {
            $assetMaintenance->completion_date = null;
            if (( $assetMaintenance->asset_maintenance_time !== 0 )
              || ( !is_null($assetMaintenance->asset_maintenance_time) )
            ) {
                $assetMaintenance->asset_maintenance_time = null;
            }
        }

        if (( $assetMaintenance->completion_date !== "" )
          && ( $assetMaintenance->completion_date !== "0000-00-00" )
          && ( $assetMaintenance->start_date !== "" )
          && ( $assetMaintenance->start_date !== "0000-00-00" )
        ) {
            $startDate                                = Carbon::parse($assetMaintenance->start_date);
            $completionDate                           = Carbon::parse($assetMaintenance->completion_date);
            $assetMaintenance->asset_maintenance_time = $completionDate->diffInDays($startDate);
        }

      // Was the asset maintenance created?
        if ($assetMaintenance->save()) {

            // Redirect to the new asset maintenance page
            return redirect()->to("admin/asset_maintenances")
                         ->with('success', trans('admin/asset_maintenances/message.create.success'));
        }
        return redirect()->back() ->withInput()->withErrors($assetMaintenance->getErrors());


    }

    /**
    *  Delete an asset maintenance
    *
    * @author  Vincent Sposato <vincent.sposato@gmail.com>
    * @param int $assetMaintenanceId
    * @version v1.0
    * @since [v1.8]
    * @return mixed
    */
    public function getDelete($assetMaintenanceId)
    {
        // Check if the asset maintenance exists
        if (is_null($assetMaintenance = AssetMaintenance::find($assetMaintenanceId))) {
            // Redirect to the asset maintenance management page
            return redirect()->to('admin/asset_maintenances')
                           ->with('error', trans('admin/asset_maintenances/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($assetMaintenance->asset)) {
            return static::getInsufficientPermissionsRedirect();
        }

        // Delete the asset maintenance
        $assetMaintenance->delete();

        // Redirect to the asset_maintenance management page
        return redirect()->to('admin/asset_maintenances')
                       ->with('success', trans('admin/asset_maintenances/message.delete.success'));
    }

    /**
    *  View an asset maintenance
    *
    * @author  Vincent Sposato <vincent.sposato@gmail.com>
    * @param int $assetMaintenanceId
    * @version v1.0
    * @since [v1.8]
    * @return View
    */
    public function getView($assetMaintenanceId)
    {
        // Check if the asset maintenance exists
        if (is_null($assetMaintenance = AssetMaintenance::find($assetMaintenanceId))) {
            // Redirect to the asset maintenance management page
            return redirect()->to('admin/asset_maintenances')
                           ->with('error', trans('admin/asset_maintenances/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($assetMaintenance->asset)) {
            return static::getInsufficientPermissionsRedirect();
        }

        return View::make('asset_maintenances/view')->with('assetMaintenance', $assetMaintenance);
    }
}
