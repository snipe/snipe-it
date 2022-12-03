<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\AccessoriesTransformer;
use App\Http\Transformers\SelectlistTransformer;
use App\Models\Accessory;
use App\Models\Company;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests\ImageUploadRequest;
use App\Models\PurchaseOrder;
use App\Http\Transformers\PurchaseTransformer;
use Illuminate\Support\Facades\Log;
class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', PurchaseOrder::class);

        // This array is what determines which fields should be allowed to be sorted on ON the table itself, no relations
        // Relations will be handled in query scopes a little further down.
        $allowed_columns = ['id', 'name', 'state'];


        $purchases = PurchaseOrder::select('purchase_orders.*')
            ->with('user');

        if ($request->filled('search')) {
            $accessories = $purchases->TextSearch($request->input('search'));
        }

        if ($request->filled('name')) {
            $purchases->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('state')) {
            $purchases->where('state', '=', $request->input('state'));
        }

        if ($request->filled('user_id')) {
            $accessories->where('user_id', '=', $request->input('user_id'));
        }

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($purchases) && ($request->get('offset') > $purchases->count())) ? $purchases->count() : $request->get('offset', 0);
        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort_override = $request->input('sort');
        $column_sort = in_array($sort_override, $allowed_columns) ? $sort_override : 'created_at';


        switch ($sort_override) {
            case 'user':
                $purchases = $purchases->OrderUser($order);
                break;
            default:
                $purchases = $purchases->orderBy($column_sort, $order);
                break;
        }

        $total = $purchases->count();
        $offset = 100;
        $purchases = $purchases->skip($offset)->take($limit)->get();
        return (new PurchaseTransformer)->transformPurchases($purchases, $total);
    }
}
