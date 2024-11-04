<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Transformers\ActionlogsTransformer;
use App\Models\Actionlog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReportsController extends Controller
{
    /**
     * Returns Activity Report JSON.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     */
    public function index(Request $request) : JsonResponse | array
    {
        $this->authorize('reports.view');

        $actionlogs = Actionlog::with('item', 'user', 'adminuser', 'target', 'location');

        if ($request->filled('search')) {
            $actionlogs = $actionlogs->TextSearch(e($request->input('search')));
        }

        if (($request->filled('target_type')) && ($request->filled('target_id'))) {
            $actionlogs = $actionlogs->where('target_id', '=', $request->input('target_id'))
                ->where('target_type', '=', 'App\\Models\\'.ucwords($request->input('target_type')));
        }

        if (($request->filled('item_type')) && ($request->filled('item_id'))) {
            $actionlogs = $actionlogs->where(function($query) use ($request)
            {
                $query->where('item_id', '=', $request->input('item_id'))
                ->where('item_type', '=', 'App\\Models\\'.ucwords($request->input('item_type')))
                ->orWhere(function($query) use ($request)
                {
                    $query->where('target_id', '=', $request->input('item_id'))
                    ->where('target_type', '=', 'App\\Models\\'.ucwords($request->input('item_type')));
                });
            });
        }


        if ($request->filled('uploads')) {
            $actionlogs = $actionlogs->whereNotNull('filename')->orderBy('created_at', 'desc');
        }

        $allowed_columns = [
            'id',
            'created_at',
            'target_id',
            'created_by',
            'accept_signature',
            'action_type',
            'note',
            'remote_ip',
            'user_agent',
            'target_type',
            'item_type',
            'action_source',
            'action_date',
        ];


        $total = $actionlogs->count();
        // Make sure the offset and limit are actually integers and do not exceed system limits
        $offset = ($request->input('offset') > $total) ? $total : app('api_offset_value');
        $limit = app('api_limit_value');

        $order = ($request->input('order') == 'asc') ? 'asc' : 'desc';

        switch ($request->input('sort')) {
            case 'created_by':
                $actionlogs->OrderByCreatedBy($order);
                break;
            default:
                $sort = in_array($request->input('sort'), $allowed_columns) ? e($request->input('sort')) : 'created_at';
                $actionlogs = $actionlogs->orderBy($sort, $order);
                break;
        }

        $actionlogs = $actionlogs->skip($offset)->take($limit)->get();

        return response()->json((new ActionlogsTransformer)->transformActionlogs($actionlogs, $total), 200, ['Content-Type' => 'application/json;charset=utf8'], JSON_UNESCAPED_UNICODE);
    }
}
