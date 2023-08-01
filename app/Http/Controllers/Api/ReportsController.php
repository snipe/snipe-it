<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Transformers\ActionlogsTransformer;
use App\Models\Actionlog;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /**
     * Returns Activity Report JSON.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return View
     */
    public function index(Request $request)
    {
        $this->authorize('reports.view');

        $actionlogs = Actionlog::with('item', 'user', 'admin', 'target', 'location');

        if ($request->filled('search')) {
            $actionlogs = $actionlogs->TextSearch(e($request->input('search')));
        }

        if (($request->filled('target_type')) && ($request->filled('target_id'))) {
            $actionlogs = $actionlogs->where('target_id', '=', $request->input('target_id'))
                ->where('target_type', '=', 'App\\Models\\'.ucwords($request->input('target_type')));
        }

        if (($request->filled('item_type')) && ($request->filled('item_id'))) {
            $actionlogs = $actionlogs->where('item_id', '=', $request->input('item_id'))
                ->where('item_type', '=', 'App\\Models\\'.ucwords($request->input('item_type')));
        }

        if ($request->filled('action_type')) {
            $actionlogs = $actionlogs->where('action_type', '=', $request->input('action_type'))->orderBy('created_at', 'desc');
        }

        if ($request->filled('uploads')) {
            $actionlogs = $actionlogs->whereNotNull('filename')->orderBy('created_at', 'desc');
        }

        $allowed_columns = [
            'id',
            'created_at',
            'target_id',
            'user_id',
            'accept_signature',
            'action_type',
            'note',
        ];


        // Make sure the offset and limit are actually integers and do not exceed system limits
        $offset = ($request->input('offset') > $actionlogs->count()) ? $actionlogs->count() : abs($request->input('offset'));
        $limit = app('api_limit_value');

        $sort = in_array($request->input('sort'), $allowed_columns) ? e($request->input('sort')) : 'created_at';
        $order = ($request->input('order') == 'asc') ? 'asc' : 'desc';
        $total = $actionlogs->count();

        $actionlogs = $actionlogs->orderBy($sort, $order)->skip($offset)->take($limit)->get();

        return response()->json((new ActionlogsTransformer)->transformActionlogs($actionlogs, $total), 200, ['Content-Type' => 'application/json;charset=utf8'], JSON_UNESCAPED_UNICODE);
    }
}
