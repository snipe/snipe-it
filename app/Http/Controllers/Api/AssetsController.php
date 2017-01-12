<?php
namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Requests\AssetCheckinRequest;
use App\Http\Requests\AssetCheckoutRequest;
use App\Http\Requests\AssetFileRequest;
use App\Http\Requests\AssetRequest;
use App\Http\Requests\ItemImportRequest;
use App\Models\Actionlog;
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
use Image;
use Input;
use Lang;
use League\Csv\Reader;
use Log;
use Mail;
use Paginator;
use Redirect;
use Response;
use Slack;
use Str;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use TCPDF;
use Validator;
use View;
use App\Http\Controllers\Controller;

/**
 * This class controls all actions related to assets for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 * @author [A. Gianotto] [<snipe@snipe.net>]
 */
class AssetsController extends Controller
{

    public function index(Request $request, $status = null)
    {
        $this->authorize('index', 'App\Models\Asset');
        
        $assets = Company::scopeCompanyables(Asset::select('assets.*'))->with(
            'assetLoc', 'assetstatus', 'defaultLoc', 'assetlog', 'company',
            'model.category', 'model.manufacturer', 'model.fieldset');

        if ($request->has('search')) {
            $assets = $assets->TextSearch(e($request->get('search')));
        }

        $offset = request('offset', 0);
        $limit = request('limit', 50);

        if ($request->has('order_number')) {
            $assets->where('order_number', '=', e($request->get('order_number')));
        }

        switch ($status) {
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

        if ($request->has('status_id')) {
            $assets->where('status_id', '=', e($request->get('status_id')));
        }

        $allowed_columns = [
            'id',
            'name',
            'asset_tag',
            'serial',
            'model',
            'model_number',
            'last_checkout',
            'category',
            'manufacturer',
            'notes',
            'expected_checkin',
            'order_number',
            'companyName',
            'location',
            'image',
            'status_label',
            'assigned_to',
            'created_at',
            'purchase_date',
            'purchase_cost'
        ];
        $all_custom_fields = CustomField::all(); //used as a 'cache' of custom fields throughout this page load
        foreach ($all_custom_fields as $field) {
            $allowed_columns[]=$field->db_column_name();
        }

        $order = $request->get('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'asset_tag';

        switch ($sort) {
            case 'model':
                $assets = $assets->OrderModels($order);
                break;
            case 'model_number':
                $assets = $assets->OrderModelNumber($order);
                break;
            case 'category':
                $assets = $assets->OrderCategory($order);
                break;
            case 'manufacturer':
                $assets = $assets->OrderManufacturer($order);
                break;
            case 'companyName':
                $assets = $assets->OrderCompany($order);
                break;
            case 'location':
                $assets = $assets->OrderLocation($order);
                break;
            case 'status_label':
                $assets = $assets->OrderStatus($order);
                break;
            case 'assigned_to':
                $assets = $assets->OrderAssigned($order);
                break;
            default:
                $assets = $assets->orderBy($sort, $order);
                break;
        }

        $assetCount = $assets->count();
        $assets = $assets->skip($offset)->take($limit)->get();

        $rows = array();
        foreach ($assets as $asset) {
            $row = $asset->present()->forDataTable($all_custom_fields);
            if (($request->has('report')) && ($request->get('report')=='true')) {
                $rows[]= Helper::stripTagsFromJSON($row);
            } else {
                $rows[]= $row;
            }

        }
        $data = array('total'=>$assetCount, 'rows'=>$rows);
        return $data;

    }


}
