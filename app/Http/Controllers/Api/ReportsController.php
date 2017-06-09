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

        $actionlogs = Actionlog::with('item', 'user', 'target');

        if ($request->has('search')) {
            $actionlogs = $actionlogs->TextSearch(e($request->input('search')));
        }

        if ($request->has('user_id')) {
            $actionlogs = $actionlogs->where('target_id','=',$request->input('user_id'))->where('target_type','=','App\\Models\\User');
        }

        if (($request->has('item_type'))  && ($request->has('item_id'))) {
            $actionlogs = $actionlogs->where('item_id','=',$request->input('item_id'))
                ->where('item_type','=',"App\\Models\\".ucwords($request->input('item_type')));
        }

        $allowed_columns = [
            'id',
            'created_at'
        ];
        
        $sort = in_array($request->input('sort'), $allowed_columns) ? e($request->input('sort')) : 'created_at';
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $offset = request('offset', 0);
        $limit = request('limit', 50);
        $total = $actionlogs->count();
        $actionlogs = $actionlogs->orderBy($sort, $order);
        $actionlogs = $actionlogs->skip($offset)->take($limit)->get();
        return (new ActionlogsTransformer)->transformActionlogs($actionlogs, $total);



    }
}
