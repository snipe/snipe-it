<?php
namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssetRequest;
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
    public function index(Request $request)
    {

        $this->authorize('index', Asset::class);

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
            'purchase_cost'
        ];

        $all_custom_fields = CustomField::all(); //used as a 'cache' of custom fields throughout this page load
        foreach ($all_custom_fields as $field) {
            $allowed_columns[]=$field->db_column_name();
        }

        $assets = Company::scopeCompanyables(Asset::select('assets.*'))->with(
            'assetLoc', 'assetstatus', 'defaultLoc', 'assetlog', 'company',
            'model.category', 'model.manufacturer', 'model.fieldset', 'assigneduser');

        if ($request->has('search')) {
            $assets->TextSearch($request->input('search'));
        }

        if ($request->has('status_id')) {
            $assets->where('status_id', '=', $request->input('status_id'));
        }

        if ($request->has('model_id')) {
            $assets->InModelList([$request->input('model_id')]);
        }

        if ($request->has('category_id')) {
            $assets->InCategory($request->input('category_id'));
        }

        if ($request->has('location_id')) {
            $assets->ByLocationId($request->input('location_id'));
        }

        if ($request->has('company_id')) {
            $assets->where('company_id','=',$request->input('company_id'));
        }

        if ($request->has('manufacturer_id')) {
            $assets->ByManufacturer($request->input('manufacturer_id'));
        }

        $request->has('order_number') ? $assets = $assets->where('order_number', '=', e($request->get('order_number'))) : '';

        $offset = request('offset', 0);
        $limit = $request->input('limit', 50);
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'assets.created_at';
        $assets->orderBy($sort, $order);

        switch ($request->input('status')) {
            case 'Deleted':
                $assets->withTrashed()->Deleted();
                break;
            case 'Pending':
                $assets->Pending();
                break;
            case 'RTD':
                $assets->RTD();
                break;
            case 'Undeployable':
                $assets->Undeployable();
                break;
            case 'Archived':
                $assets->Archived();
                break;
            case 'Requestable':
                $assets->RequestableAssets();
                break;
            case 'Deployed':
                $assets->Deployed();
                break;
        }



        switch ($sort) {
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
                break;
            case 'status_label':
                $assets->OrderStatus($order);
                break;
            case 'assigned_to':
                $assets->OrderAssigned($order);
                break;
            default:
                $assets->orderBy($sort, $order);
                break;
        }


        $total = $assets->count();
        $assets = $assets->skip($offset)->take($limit)->get();
        return (new AssetsTransformer)->transformAssets($assets, $total);

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

        if ($asset = Asset::withTrashed()->find($id)) {
            $this->authorize('view', $asset);

            $asset = $asset->present()->detail();
            return (new AssetsTransformer)->transformAsset($asset);

        }

        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/hardware/message.does_not_exist')), 404);

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
        $asset->model()->associate(AssetModel::find(e($request->get('model_id'))));

        $asset->name                    = $request->get('name');
        $asset->serial                  = $request->get('serial');
        $asset->company_id              = Company::getIdForCurrentUser($request->get('company_id'));
        $asset->model_id                = $request->get('model_id');
        $asset->order_number            = $request->get('order_number');
        $asset->notes                   = $request->get('notes');
        $asset->asset_tag               = $request->get('asset_tag');
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
                $asset->{$field->convertUnicodeDbSlug()} = e($request->input($field->convertUnicodeDbSlug()));
            }
        }

        if ($asset->save()) {
            $asset->logCreate();
            if($request->get('assigned_user')) {
                $target = User::find(request('assigned_user'));
            } elseif($request->get('assigned_asset')) {
                $target = Asset::find(request('assigned_asset'));
            } elseif($request->get('assigned_location')) {
                $target = Location::find(request('assigned_location'));
            }
            if (isset($target)) {
                $asset->checkOut($target, Auth::user(), date('Y-m-d H:i:s'), '', 'Checked out on asset creation', e($request->get('name')));
            }
            return response()->json(Helper::formatStandardApiResponse('success', $asset->id,  trans('admin/hardware/message.create.success')));

        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $asset->getErrors()), 500);


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
        $this->authorize('create', Asset::class);

        if ($asset = Asset::find($id)) {

            ($request->has('model_id')) ?
                $asset->model()->associate(AssetModel::find($request->get('model_id'))) : '';
            ($request->has('name')) ? $asset->name = $request->get('name') : '';
            ($request->has('serial')) ? $asset->serial = $request->get('serial') : '';
            ($request->has('model_id')) ? $asset->model_id = $request->get('model_id') : '';
            ($request->has('order_number')) ? $asset->order_number = $request->get('order_number') : '';
            ($request->has('notes')) ? $asset->notes = $request->get('notes') : '';
            ($request->has('asset_tag')) ? $asset->asset_tag = $request->get('asset_tag') : '';
            ($request->has('archived')) ? $asset->archived = $request->get('archived') : '';
            ($request->has('status_id')) ? $asset->status_id = $request->get('status_id') : '';
            ($request->has('warranty_months')) ? $asset->warranty_months = $request->get('warranty_months') : '';
            ($request->has('purchase_cost')) ?
                $asset->purchase_cost = Helper::ParseFloat($request->get('purchase_cost')) : '';
            ($request->has('purchase_date')) ? $asset->purchase_date = $request->get('purchase_date') : '';
            ($request->has('assigned_to')) ? $asset->assigned_to = $request->get('assigned_to') : '';
            ($request->has('supplier_id')) ? $asset->supplier_id = $request->get('supplier_id') : '';
            ($request->has('requestable')) ? $asset->name = $request->get('requestable') : '';
            ($request->has('archived')) ? $asset->name = $request->get('archived') : '';
            ($request->has('rtd_location_id')) ? $asset->name = $request->get('rtd_location_id') : '';
            ($request->has('company_id')) ?
                $asset->company_id = Company::getIdForCurrentUser($request->get('company_id')) : '';

            if ($request->has('model_id')) {
                if (($model = AssetModel::find($request->get('model_id'))) && (isset($model->fieldset))) {
                    foreach ($model->fieldset->fields as $field) {
                        if ($request->has($field->convertUnicodeDbSlug())) {
                            $asset->{$field->convertUnicodeDbSlug()} = e($request->input($field->convertUnicodeDbSlug()));
                        }

                    }
                }
            }



            if ($asset->save()) {

                $asset->logCreate();
                if($request->get('assigned_user')) {
                    $target = User::find(request('assigned_user'));
                } elseif($request->get('assigned_asset')) {
                    $target = Asset::find(request('assigned_asset'));
                } elseif($request->get('assigned_location')) {
                    $target = Location::find(request('assigned_location'));
                }

                if (isset($target)) {
                    $asset->checkOut($target, Auth::user(), date('Y-m-d H:i:s'), '', 'Checked out on asset update', e($request->get('name')));
                }

                return response()->json(Helper::formatStandardApiResponse('success', $asset,  trans('admin/hardware/message.update.success')));

            }
            return response()->json(Helper::formatStandardApiResponse('error', null, $asset->getErrors()), 500);

        }


        return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/hardware/message.does_not_exist')), 404);


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

        if ($asset = Asset::find($id)) {
            $this->authorize('delete', $asset);

            DB::table('assets')
                ->where('id', $asset->id)
                ->update(array('assigned_to' => null));

            $asset->delete();
            return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/hardware/message.delete.success')));

        }
        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/hardware/message.does_not_exist')), 404);

    }

}
