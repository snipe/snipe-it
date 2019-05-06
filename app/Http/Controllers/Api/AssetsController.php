<?php
namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssetRequest;
use App\Http\Requests\AssetCheckoutRequest;
use App\Http\Transformers\AssetsTransformer;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\CustomField;
use App\Models\Location;
use App\Models\Setting;
use App\Models\User;
use Artisan;
use Auth;
use Carbon\Carbon;
use Config;
use DB;
use Gate;
use Illuminate\Http\Request;
use Input;
use Lang;
use Log;
use Mail;
use Paginator;
use Response;
use Slack;
use Str;
use TCPDF;
use Validator;
use View;
use App\Http\Transformers\SelectlistTransformer;


/**
 * This class controls all actions related to assets for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 * @author [A. Gianotto] [<snipe@snipe.net>]
 */
class AssetsController extends Controller
{

    /**
     * Returns JSON listing of all assets
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @since [v4.0]
     * @return JsonResponse
     */
    public function index(Request $request, $audit = null)
    {

        $this->authorize('index', Asset::class);
        $settings = Setting::getSettings();

        $allowed_columns = [
            'id',
            'name',
            'asset_tag',
            'serial',
            'model_number',
            'last_checkout',
            'notes',
            'expected_checkin',
            'order_number',
            'image',
            'assigned_to',
            'created_at',
            'updated_at',
            'purchase_date',
            'purchase_cost',
            'last_audit_date',
            'next_audit_date',
            'warranty_months',
            'checkout_counter',
            'checkin_counter',
            'requests_counter',
        ];

        $filter = array();

        if ($request->has('filter')) {
            $filter = json_decode($request->input('filter'), true);
        }

        $all_custom_fields = CustomField::all(); //used as a 'cache' of custom fields throughout this page load
        foreach ($all_custom_fields as $field) {
            $allowed_columns[]=$field->db_column_name();
        }

        $assets = Company::scopeCompanyables(Asset::select('assets.*'),"company_id","assets")
            ->with('location', 'assetstatus', 'assetlog', 'company', 'defaultLoc','assignedTo',
                'model.category', 'model.manufacturer', 'model.fieldset','supplier');


        // These are used by the API to query against specific ID numbers.
        // They are also used by the individual searches on detail pages like
        // locations, etc.
        if ($request->has('status_id')) {
            $assets->where('assets.status_id', '=', $request->input('status_id'));
        }

        if ($request->input('requestable')=='true') {
            $assets->where('assets.requestable', '=', '1');
        }

        if ($request->has('model_id')) {
            $assets->InModelList([$request->input('model_id')]);
        }

        if ($request->has('category_id')) {
            $assets->InCategory($request->input('category_id'));
        }

        if ($request->has('location_id')) {
            $assets->where('assets.location_id', '=', $request->input('location_id'));
        }

        if ($request->has('supplier_id')) {
            $assets->where('assets.supplier_id', '=', $request->input('supplier_id'));
        }

        if (($request->has('assigned_to')) && ($request->has('assigned_type'))) {
            $assets->where('assets.assigned_to', '=', $request->input('assigned_to'))
                ->where('assets.assigned_type', '=', $request->input('assigned_type'));
        }

        if ($request->has('company_id')) {
            $assets->where('assets.company_id', '=', $request->input('company_id'));
        }

        if ($request->has('manufacturer_id')) {
            $assets->ByManufacturer($request->input('manufacturer_id'));
        }

        if ($request->has('depreciation_id')) {
            $assets->ByDepreciationId($request->input('depreciation_id'));
        }

        $request->has('order_number') ? $assets = $assets->where('assets.order_number', '=', e($request->get('order_number'))) : '';

        $offset = (($assets) && (request('offset') > $assets->count())) ? 0 : request('offset', 0);
        $limit = $request->input('limit', 50);
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';

        // This is used by the audit reporting routes
        if (Gate::allows('audit', Asset::class)) {

            switch ($audit) {
                case 'due':
                    $assets->DueOrOverdueForAudit($settings);
                    break;
                case 'overdue':
                    $assets->overdueForAudit($settings);
                    break;
            }
        }



        // This is used by the sidenav, mostly

        // We switched from using query scopes here because of a Laravel bug
        // related to fulltext searches on complex queries.
        // I am sad. :(
        switch ($request->input('status')) {
            case 'Deleted':
                $assets->withTrashed()->Deleted();
                break;
            case 'Pending':
                $assets->join('status_labels AS status_alias',function ($join) {
                    $join->on('status_alias.id', "=", "assets.status_id")
                        ->where('status_alias.deployable','=',0)
                        ->where('status_alias.pending','=',1)
                        ->where('status_alias.archived', '=', 0);
                });
                break;
            case 'RTD':
                $assets->whereNull('assets.assigned_to')
                    ->join('status_labels AS status_alias',function ($join) {
                        $join->on('status_alias.id', "=", "assets.status_id")
                            ->where('status_alias.deployable','=',1)
                            ->where('status_alias.pending','=',0)
                            ->where('status_alias.archived', '=', 0);
                    });
                break;
            case 'Undeployable':
                $assets->Undeployable();
                break;
            case 'Archived':
                $assets->join('status_labels AS status_alias',function ($join) {
                    $join->on('status_alias.id', "=", "assets.status_id")
                        ->where('status_alias.deployable','=',0)
                        ->where('status_alias.pending','=',0)
                        ->where('status_alias.archived', '=', 1);
                });
                break;
            case 'Requestable':
                $assets->where('assets.requestable', '=', 1)
                    ->join('status_labels AS status_alias',function ($join) {
                        $join->on('status_alias.id', "=", "assets.status_id")
                            ->where('status_alias.deployable','=',1)
                            ->where('status_alias.pending','=',0)
                            ->where('status_alias.archived', '=', 0);
                    });

                break;
            case 'Deployed':
                // more sad, horrible workarounds for laravel bugs when doing full text searches
                $assets->where('assets.assigned_to', '>', '0');
                break;
            default:

                if ((!$request->has('status_id')) && ($settings->show_archived_in_list!='1')) {
                    // terrible workaround for complex-query Laravel bug in fulltext
                    $assets->join('status_labels AS status_alias',function ($join) {
                        $join->on('status_alias.id', "=", "assets.status_id")
                            ->where('status_alias.archived', '=', 0);
                    });

                    // If there is a status ID, don't take show_archived_in_list into consideration
                } else {
                    $assets->join('status_labels AS status_alias',function ($join) {
                        $join->on('status_alias.id', "=", "assets.status_id");
                    });
                }

        }


        if ((!is_null($filter)) && (count($filter)) > 0) {
            $assets->ByFilter($filter);
        } elseif ($request->has('search')) {
            $assets->TextSearch($request->input('search'));
        }


        // This is kinda gross, but we need to do this because the Bootstrap Tables
        // API passes custom field ordering as custom_fields.fieldname, and we have to strip
        // that out to let the default sorter below order them correctly on the assets table.
        $sort_override = str_replace('custom_fields.','', $request->input('sort')) ;

        // This handles all of the pivot sorting (versus the assets.* fields
        // in the allowed_columns array)
        $column_sort = in_array($sort_override, $allowed_columns) ? $sort_override : 'assets.created_at';


        switch ($sort_override) {
            case 'model':
                $assets->OrderModels($order);
                break;
            case 'model_number':
                $assets->OrderModelNumber($order);
                break;
            case 'category':
                $assets->OrderCategory($order);
                break;
            case 'manufacturer':
                $assets->OrderManufacturer($order);
                break;
            case 'company':
                $assets->OrderCompany($order);
                break;
            case 'location':
                $assets->OrderLocation($order);
            case 'rtd_location':
                $assets->OrderRtdLocation($order);
                break;
            case 'status_label':
                $assets->OrderStatus($order);
                break;
            case 'supplier':
                $assets->OrderSupplier($order);
                break;
            case 'assigned_to':
                $assets->OrderAssigned($order);
                break;
            default:
                $assets->orderBy($column_sort, $order);
                break;
        }


        $total = $assets->count();
        $assets = $assets->skip($offset)->take($limit)->get();
        return (new AssetsTransformer)->transformAssets($assets, $total);
    }


    /**
     * Returns JSON with information about an asset (by tag) for detail view.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param string $tag
     * @since [v4.2.1]
     * @return JsonResponse
     */
    public function showByTag($tag)
    {
        if ($asset = Asset::with('assetstatus')->with('assignedTo')->withTrashed()->where('asset_tag',$tag)->first()) {
            $this->authorize('view', $asset);
            return (new AssetsTransformer)->transformAsset($asset);
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, 'Asset not found'), 200);

    }

    /**
     * Returns JSON with information about an asset (by serial) for detail view.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param string $serial
     * @since [v4.2.1]
     * @return JsonResponse
     */
    public function showBySerial($serial)
    {
        $this->authorize('index', Asset::class);
        if ($assets = Asset::with('assetstatus')->with('assignedTo')
            ->withTrashed()->where('serial',$serial)->get()) {

            return (new AssetsTransformer)->transformAssets($assets, $assets->count());
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, 'Asset not found'), 200);

    }


    /**
     * Returns JSON with information about an asset for detail view.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @since [v4.0]
     * @return JsonResponse
     */
    public function show($id)
    {
        if ($asset = Asset::with('assetstatus')->with('assignedTo')->withTrashed()->withCount('checkins', 'checkouts', 'userRequests')->findOrFail($id)) {
            $this->authorize('view', $asset);
            return (new AssetsTransformer)->transformAsset($asset);
        }


    }


    /**
     * Gets a paginated collection for the select2 menus
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0.16]
     * @see \App\Http\Transformers\SelectlistTransformer
     *
     */
    public function selectlist(Request $request)
    {

        $assets = Company::scopeCompanyables(Asset::select([
            'assets.id',
            'assets.name',
            'assets.asset_tag',
            'assets.model_id',
            'assets.assigned_to',
            'assets.assigned_type',
            'assets.status_id'
        ])->with('model', 'assetstatus', 'assignedTo')->NotArchived(),'company_id', 'assets');

        if ($request->has('assetStatusType') && $request->input('assetStatusType') === 'RTD') {
            $assets = $assets->RTD();
        }

        if ($request->has('search')) {
            $assets = $assets->AssignedSearch($request->input('search'));
        }


        $assets = $assets->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($assets as $asset) {


            $asset->use_text = $asset->present()->fullName;

            if (($asset->checkedOutToUser()) && ($asset->assigned)) {
                $asset->use_text .= ' → '.$asset->assigned->getFullNameAttribute();
            }


            if ($asset->assetstatus->getStatuslabelType()=='pending') {
                $asset->use_text .=  '('.$asset->assetstatus->getStatuslabelType().')';
            }

            $asset->use_image = ($asset->getImageUrl()) ? $asset->getImageUrl() : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($assets);

    }


    /**
     * Accepts a POST request to create a new asset
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param Request $request
     * @since [v4.0]
     * @return JsonResponse
     */
    public function store(AssetRequest $request)
    {

        $this->authorize('create', Asset::class);

        $asset = new Asset();
        $asset->model()->associate(AssetModel::find((int) $request->get('model_id')));

        $asset->name                    = $request->get('name');
        $asset->serial                  = $request->get('serial');
        $asset->company_id              = Company::getIdForCurrentUser($request->get('company_id'));
        $asset->model_id                = $request->get('model_id');
        $asset->order_number            = $request->get('order_number');
        $asset->notes                   = $request->get('notes');
        $asset->asset_tag               = $request->get('asset_tag', Asset::autoincrement_asset());
        $asset->user_id                 = Auth::id();
        $asset->archived                = '0';
        $asset->physical                = '1';
        $asset->depreciate              = '0';
        $asset->status_id               = $request->get('status_id', 0);
        $asset->warranty_months         = $request->get('warranty_months', null);
        $asset->purchase_cost           = Helper::ParseFloat($request->get('purchase_cost'));
        $asset->purchase_date           = $request->get('purchase_date', null);
        $asset->assigned_to             = $request->get('assigned_to', null);
        $asset->supplier_id             = $request->get('supplier_id', 0);
        $asset->requestable             = $request->get('requestable', 0);
        $asset->rtd_location_id         = $request->get('rtd_location_id', null);

        // Update custom fields in the database.
        // Validation for these fields is handled through the AssetRequest form request
        $model = AssetModel::find($request->get('model_id'));
        if ($model->fieldset) {
            foreach ($model->fieldset->fields as $field) {
                $asset->{$field->convertUnicodeDbSlug()} = e($request->input($field->convertUnicodeDbSlug(), null));
            }
        }

        if ($asset->save()) {

            if ($request->get('assigned_user')) {
                $target = User::find(request('assigned_user'));
            } elseif ($request->get('assigned_asset')) {
                $target = Asset::find(request('assigned_asset'));
            } elseif ($request->get('assigned_location')) {
                $target = Location::find(request('assigned_location'));
            }
            if (isset($target)) {
                $asset->checkOut($target, Auth::user(), date('Y-m-d H:i:s'), '', 'Checked out on asset creation', e($request->get('name')));
            }
            return response()->json(Helper::formatStandardApiResponse('success', $asset, trans('admin/hardware/message.create.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $asset->getErrors()), 200);
    }


    /**
     * Accepts a POST request to update an asset
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param Request $request
     * @since [v4.0]
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update', Asset::class);

        if ($asset = Asset::find($id)) {

            $asset->fill($request->all());

            ($request->has('model_id')) ?
                $asset->model()->associate(AssetModel::find($request->get('model_id'))) : null;
            ($request->has('company_id')) ?
                $asset->company_id = Company::getIdForCurrentUser($request->get('company_id')) : null;
            ($request->has('rtd_location_id')) ?
                $asset->location_id = $request->get('rtd_location_id') : null;

            // Update custom fields
            if (($model = AssetModel::find($asset->model_id)) && (isset($model->fieldset))) {
                foreach ($model->fieldset->fields as $field) {
                    if ($request->has($field->convertUnicodeDbSlug())) {
                        $asset->{$field->convertUnicodeDbSlug()} = e($request->input($field->convertUnicodeDbSlug()));
                    }
                }
            }


            if ($asset->save()) {

                if (($request->has('assigned_user')) && ($target = User::find($request->get('assigned_user')))) {
                    $location = $target->location_id;
                } elseif (($request->has('assigned_asset')) && ($target = Asset::find($request->get('assigned_asset')))) {
                    $location = $target->location_id;
                } elseif (($request->has('assigned_location')) && ($target = Location::find($request->get('assigned_location')))) {
                    $location = $target->id;
                }

                if (isset($target)) {
                    $asset->checkOut($target, Auth::user(), date('Y-m-d H:i:s'), '', 'Checked out on asset update', e($request->get('name')), $location);
                }

                return response()->json(Helper::formatStandardApiResponse('success', $asset, trans('admin/hardware/message.update.success')));
            }
            return response()->json(Helper::formatStandardApiResponse('error', null, $asset->getErrors()), 200);
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/hardware/message.does_not_exist')), 200);
    }


    /**
     * Delete a given asset (mark as deleted).
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @since [v4.0]
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $this->authorize('delete', Asset::class);

        if ($asset = Asset::find($id)) {

            $this->authorize('delete', $asset);

            DB::table('assets')
                ->where('id', $asset->id)
                ->update(array('assigned_to' => null));

            $asset->delete();

            return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/hardware/message.delete.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/hardware/message.does_not_exist')), 200);
    }



    /**
     * Checkout an asset
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @since [v4.0]
     * @return JsonResponse
     */
    public function checkout(AssetCheckoutRequest $request, $asset_id)
    {
        $this->authorize('checkout', Asset::class);
        $asset = Asset::findOrFail($asset_id);

        if (!$asset->availableForCheckout()) {
            return response()->json(Helper::formatStandardApiResponse('error', ['asset'=> e($asset->asset_tag)], trans('admin/hardware/message.checkout.not_available')));
        }

        $this->authorize('checkout', $asset);

        $error_payload = [];
        $error_payload['asset'] = [
            'id' => $asset->id,
            'asset_tag' => $asset->asset_tag,
        ];


        // This item is checked out to a location
        if (request('checkout_to_type')=='location') {
            $target = Location::find(request('assigned_location'));
            $asset->location_id = ($target) ? $target->id : '';
            $error_payload['target_id'] = $request->input('assigned_location');
            $error_payload['target_type'] = 'location';

        } elseif (request('checkout_to_type')=='asset') {
            $target = Asset::where('id','!=',$asset_id)->find(request('assigned_asset'));
            $asset->location_id = $target->rtd_location_id;
            // Override with the asset's location_id if it has one
            if ($target->location_id!='') {
                $asset->location_id = ($target) ? $target->location_id : '';
            }
            $error_payload['target_id'] = $request->input('assigned_asset');
            $error_payload['target_type'] = 'asset';

        } elseif (request('checkout_to_type')=='user') {
            // Fetch the target and set the asset's new location_id
            $target = User::find(request('assigned_user'));
            $asset->location_id = ($target) ? $target->location_id : '';
            $error_payload['target_id'] = $request->input('assigned_user');
            $error_payload['target_type'] = 'user';
        }



        if (!isset($target)) {
            return response()->json(Helper::formatStandardApiResponse('error', $error_payload, 'Checkout target for asset '.e($asset->asset_tag).' is invalid - '.$error_payload['target_type'].' does not exist.'));
        }



        $checkout_at = request('checkout_at', date("Y-m-d H:i:s"));
        $expected_checkin = request('expected_checkin', null);
        $note = request('note', null);
        $asset_name = request('name', null);

        // Set the location ID to the RTD location id if there is one
        if ($asset->rtd_location_id!='') {
            $asset->location_id = $target->rtd_location_id;
        }





        if ($asset->checkOut($target, Auth::user(), $checkout_at, $expected_checkin, $note, $asset_name, $asset->location_id)) {
            return response()->json(Helper::formatStandardApiResponse('success', ['asset'=> e($asset->asset_tag)], trans('admin/hardware/message.checkout.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', ['asset'=> e($asset->asset_tag)], trans('admin/hardware/message.checkout.error')))->withErrors($asset->getErrors());
    }


    /**
     * Checkin an asset
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @since [v4.0]
     * @return JsonResponse
     */
    public function checkin(Request $request, $asset_id)
    {
        $this->authorize('checkin', Asset::class);
        $asset = Asset::findOrFail($asset_id);
        $this->authorize('checkin', $asset);


        $user = $asset->assignedUser;
        if (is_null($target = $asset->assignedTo)) {
            return response()->json(Helper::formatStandardApiResponse('error', ['asset'=> e($asset->asset_tag)], trans('admin/hardware/message.checkin.already_checked_in')));
        }

        $asset->expected_checkin = null;
        $asset->last_checkout = null;
        $asset->assigned_to = null;
        $asset->assignedTo()->disassociate($asset);
        $asset->accepted = null;
        $asset->name = Input::get('name');
        $asset->location_id =  $asset->rtd_location_id;

        if ($request->has('location_id')) {
            $asset->location_id =  $request->input('location_id');
        }

        if (Input::has('status_id')) {
            $asset->status_id =  Input::get('status_id');
        }

        if ($asset->save()) {
            $asset->logCheckin($target, e(request('note')));
            return response()->json(Helper::formatStandardApiResponse('success', ['asset'=> e($asset->asset_tag)], trans('admin/hardware/message.checkin.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('success', ['asset'=> e($asset->asset_tag)], trans('admin/hardware/message.checkin.error')));
    }


    /**
     * Mark an asset as audited
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $id
     * @since [v4.0]
     * @return JsonResponse
     */
    public function audit(Request $request) {


        $this->authorize('audit', Asset::class);
        $rules = array(
            'asset_tag' => 'required',
            'location_id' => 'exists:locations,id|nullable|numeric',
            'next_audit_date' => 'date|nullable'
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(Helper::formatStandardApiResponse('error', null, $validator->errors()->all()));
        }

        $asset = Asset::where('asset_tag','=', $request->input('asset_tag'))->first();


        if ($asset) {
            // We don't want to log this as a normal update, so let's bypass that
            $asset->unsetEventDispatcher();
            $asset->next_audit_date = $request->input('next_audit_date');
            $asset->last_audit_date = date('Y-m-d h:i:s');

            if ($asset->save()) {
                $log = $asset->logAudit(request('note'),request('location_id'));
                return response()->json(Helper::formatStandardApiResponse('success', [
                    'asset_tag'=> e($asset->asset_tag),
                    'note'=> e($request->input('note')),
                    'next_audit_date' => Helper::getFormattedDateObject($log->calcNextAuditDate())
                ], trans('admin/hardware/message.audit.success')));
            }
        }

        return response()->json(Helper::formatStandardApiResponse('error', ['asset_tag'=> e($request->input('asset_tag'))], 'Asset with tag '.$request->input('asset_tag').' not found'));





    }



    /**
     * Returns JSON listing of all requestable assets
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return JsonResponse
     */
    public function requestable(Request $request)
    {
        $this->authorize('viewRequestable', Asset::class);

        $assets = Company::scopeCompanyables(Asset::select('assets.*'),"company_id","assets")
            ->with('location', 'assetstatus', 'assetlog', 'company', 'defaultLoc','assignedTo',
                'model.category', 'model.manufacturer', 'model.fieldset','supplier')->where('assets.requestable', '=', '1');

        $offset = request('offset', 0);
        $limit = $request->input('limit', 50);
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $assets->TextSearch($request->input('search'));

        switch ($request->input('sort')) {
            case 'model':
                $assets->OrderModels($order);
                break;
            case 'model_number':
                $assets->OrderModelNumber($order);
                break;
            case 'category':
                $assets->OrderCategory($order);
                break;
            case 'manufacturer':
                $assets->OrderManufacturer($order);
                break;
            default:
                $assets->orderBy('assets.created_at', $order);
                break;
        }


        $total = $assets->count();
        $assets = $assets->skip($offset)->take($limit)->get();
        return (new AssetsTransformer)->transformRequestedAssets($assets, $total);
    }
}
