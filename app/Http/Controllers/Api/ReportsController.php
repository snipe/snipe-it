<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Actionlog;
use App\Http\Transformers\ActionlogsTransformer;

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
        
        $actionlogs = Actionlog::with('item', 'user', 'target','location');

        if ($request->has('search')) {
            $actionlogs = $actionlogs->TextSearch(e($request->input('search')));
        }

        if (($request->has('target_type'))  && ($request->has('target_id'))) {
            $actionlogs = $actionlogs->where('target_id','=',$request->input('target_id'))
                ->where('target_type','=',"App\\Models\\".ucwords($request->input('target_type')));
        }

        if (($request->has('item_type'))  && ($request->has('item_id'))) {
            $actionlogs = $actionlogs->where('item_id','=',$request->input('item_id'))
                ->where('item_type','=',"App\\Models\\".ucwords($request->input('item_type')));
        }

        if ($request->has('action_type')) {
            $actionlogs = $actionlogs->where('action_type','=',$request->input('action_type'))->orderBy('created_at', 'desc');
        }

        if ($request->has('uploads')) {
            $actionlogs = $actionlogs->whereNotNull('filename')->orderBy('created_at', 'desc');
        }

        $allowed_columns = [
            'id',
            'created_at',
            'target_id',
            'user_id',
            'action_type',
            'note'
        ];
        
        $sort = in_array($request->input('sort'), $allowed_columns) ? e($request->input('sort')) : 'created_at';
        $order = ($request->input('order') == 'asc') ? 'asc' : 'desc';
        $offset = request('offset', 0);
        $limit = request('limit', 50);
        $total = $actionlogs->count();
        $actionlogs = $actionlogs->orderBy($sort, $order)->skip($offset)->take($limit)->get();

        return response()->json((new ActionlogsTransformer)->transformActionlogs($actionlogs, $total), 200, ['Content-Type' => 'application/json;charset=utf8'], JSON_UNESCAPED_UNICODE);

    }
}
