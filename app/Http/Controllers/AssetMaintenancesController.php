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
use Response;
use Slack;
use Str;
use TCPDF;
use Validator;
use View;
use App\Models\Setting;
use App\Models\Asset;
use App\Helpers\Helper;
use Auth;
use Gate;
use Illuminate\Http\Request;

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
        return redirect()->route('maintenances.index')
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
    public function index()
    {
        return view('asset_maintenances/index');
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
    public function getDatatable(Request $request)
    {
        $maintenances = AssetMaintenance::with('asset', 'supplier', 'asset.company', 'admin');

        if (Input::has('search')) {
            $maintenances = $maintenances->TextSearch(e($request->input('search')));
        }

        $offset = request('offset', 0);
        $limit = request('limit', 50);

        $allowed_columns = ['id','title','asset_maintenance_time','asset_maintenance_type','cost','start_date','completion_date','notes','user_id'];
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array(Input::get('sort'), $allowed_columns) ? e($request->input('sort')) : 'created_at';

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
            if (Gate::allows('update', Asset::class)) {
                $actions .= Helper::generateDatatableButton('edit', route('maintenances.edit', $maintenance->id));
                $actions .= Helper::generateDatatableButton(
                    'delete',
                    route('maintenances.destroy', $maintenance->id),
                    $enabled = true,
                    trans('admin/asset_maintenances/message.delete.confirm'),
                    $maintenance->title
                );
            }

            if (($maintenance->cost) && (isset($maintenance->asset)) && ($maintenance->asset->location) &&  ($maintenance->asset->location->currency!='')) {
                $maintenance_cost = $maintenance->asset->location->currency.$maintenance->cost;
            } else {
                $maintenance_cost = $settings->default_currency.$maintenance->cost;
            }

            $rows[] = array(
                'id'            => $maintenance->id,
                'asset_name'    =>  ($maintenance->asset) ? (string)link_to_route('maintenances.show', $maintenance->asset->present()->Name(), ['maintenance' => $maintenance->asset->id]) : 'Deleted Asset' ,
                'title'         => $maintenance->title,
                'notes'         => $maintenance->notes,
                'supplier'      => ($maintenance->supplier) ? (string)link_to_route('suppliers.show', $maintenance->supplier->name, ['maintenance'=>$maintenance->supplier->id]) : 'Deleted Supplier',
                'cost'          => $maintenance_cost,
                'asset_maintenance_type'          => e($maintenance->asset_maintenance_type),
                'start_date'         => $maintenance->start_date,
                'asset_maintenance_time'          => $maintenance->asset_maintenance_time,
                'completion_date'     => $maintenance->completion_date,
                'user_id'       => ($maintenance->admin) ? (string)link_to_route('users.show', $maintenance->admin->present()->fullName(), ['user'=>$maintenance->admin->id]) : '',
                'actions'       => $actions,
                'company'   => ($maintenance->asset->company) ? $maintenance->asset->company->name : ''
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
    public function create()
    {
        $asset = null;

        if ($asset = Asset::find(request('asset_id'))) {
            // We have to set this so that the correct property is set in the select2 ajax dropdown
            $asset->asset_id = $asset->id;
        }

        // Prepare Asset Maintenance Type List
        $assetMaintenanceType = [
                                    '' => 'Select an asset maintenance type',
                                ] + AssetMaintenance::getImprovementOptions();
        // Mark the selected asset, if it came in

        return view('asset_maintenances/edit')
                   ->with('asset', $asset)
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
    public function store(Request $request)
    {
        // create a new model instance
        $assetMaintenance = new AssetMaintenance();
        $assetMaintenance->supplier_id = $request->input('supplier_id');
        $assetMaintenance->is_warranty = $request->input('is_warranty');
        $assetMaintenance->cost =  e($request->input('cost'));
        $assetMaintenance->notes = e($request->input('notes'));
        $asset = Asset::find(e($request->input('asset_id')));

        if (!Company::isCurrentUserHasAccess($asset)) {
            return static::getInsufficientPermissionsRedirect();
        }

        // Save the asset maintenance data
        $assetMaintenance->asset_id               = $request->input('asset_id');
        $assetMaintenance->asset_maintenance_type = $request->input('asset_maintenance_type');
        $assetMaintenance->title                  = $request->input('title');
        $assetMaintenance->start_date             = $request->input('start_date');
        $assetMaintenance->completion_date        = $request->input('completion_date');
        $assetMaintenance->user_id                = Auth::id();

        if (( $assetMaintenance->completion_date !== null )
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
            return redirect()->route('maintenances.index')
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
    public function edit($assetMaintenanceId = null)
    {
        // Check if the asset maintenance exists
        if (is_null($assetMaintenance = AssetMaintenance::find($assetMaintenanceId))) {
            // Redirect to the improvement management page
            return redirect()->route('maintenances.index')
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

        // Get Supplier List
        // Render the view
        return view('asset_maintenances/edit')
                   ->with('asset_list', Helper::detailedAssetList())
                   ->with('selectedAsset', null)
                   ->with('supplier_list', Helper::suppliersList())
                   ->with('assetMaintenanceType', $assetMaintenanceType)
                   ->with('item', $assetMaintenance);

    }

    /**
     *  Validates and stores an update to an asset maintenance
     *
     * @see AssetMaintenancesController::postEdit() method that stores the data
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @param Request $request
     * @param int $assetMaintenanceId
     * @return mixed
     * @version v1.0
     * @since [v1.8]
     */
    public function update(Request $request, $assetMaintenanceId = null)
    {
        // Check if the asset maintenance exists
        if (is_null($assetMaintenance = AssetMaintenance::find($assetMaintenanceId))) {
            // Redirect to the asset maintenance management page
            return redirect()->route('maintenances.index')
                           ->with('error', trans('admin/asset_maintenances/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($assetMaintenance->asset)) {
            return static::getInsufficientPermissionsRedirect();
        }

        $assetMaintenance->supplier_id = e($request->input('supplier_id'));
        $assetMaintenance->is_warranty = e($request->input('is_warranty'));
        $assetMaintenance->cost =  Helper::ParseFloat(e($request->input('cost')));
        $assetMaintenance->notes = e($request->input('notes'));

        $asset = Asset::find(request('asset_id'));

        if (!Company::isCurrentUserHasAccess($asset)) {
            return static::getInsufficientPermissionsRedirect();
        }

        // Save the asset maintenance data
        $assetMaintenance->asset_id               = $request->input('asset_id');
        $assetMaintenance->asset_maintenance_type = $request->input('asset_maintenance_type');
        $assetMaintenance->title                  = $request->input('title');
        $assetMaintenance->start_date             = $request->input('start_date');
        $assetMaintenance->completion_date        = $request->input('completion_date');

        if (( $assetMaintenance->completion_date == null )
        ) {
            if (( $assetMaintenance->asset_maintenance_time !== 0 )
              || ( !is_null($assetMaintenance->asset_maintenance_time) )
            ) {
                $assetMaintenance->asset_maintenance_time = null;
            }
        }

        if (( $assetMaintenance->completion_date !== null )
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
            return redirect()->route('maintenances.index')
                         ->with('success', trans('admin/asset_maintenances/message.edit.success'));
        }
        return redirect()->back()->withInput()->withErrors($assetMaintenance->getErrors());
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
    public function destroy($assetMaintenanceId)
    {
        // Check if the asset maintenance exists
        if (is_null($assetMaintenance = AssetMaintenance::find($assetMaintenanceId))) {
            // Redirect to the asset maintenance management page
            return redirect()->route('maintenances.index')
                           ->with('error', trans('admin/asset_maintenances/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($assetMaintenance->asset)) {
            return static::getInsufficientPermissionsRedirect();
        }

        // Delete the asset maintenance
        $assetMaintenance->delete();

        // Redirect to the asset_maintenance management page
        return redirect()->route('maintenances.index')
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
    public function show($assetMaintenanceId)
    {
        // Check if the asset maintenance exists
        if (is_null($assetMaintenance = AssetMaintenance::find($assetMaintenanceId))) {
            // Redirect to the asset maintenance management page
            return redirect()->route('maintenances.index')
                           ->with('error', trans('admin/asset_maintenances/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($assetMaintenance->asset)) {
            return static::getInsufficientPermissionsRedirect();
        }

        return view('asset_maintenances/view')->with('assetMaintenance', $assetMaintenance);
    }
}
