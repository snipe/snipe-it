<?php

namespace App\Http\Controllers\Api;

use App\Http\Transformers\InventoryStatuslabelsTransformer;
use App\Models\InventoryStatuslabel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Statuslabel;
use App\Http\Transformers\StatuslabelsTransformer;

class InventoryStatuslabelsController extends Controller
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
        $this->authorize('view', Statuslabel::class);

        $allowed_columns = ['id','name','success','created_at','color'];

        $statuslabels = InventoryStatuslabel::select([
            'inventory_status_labels.id',
            'inventory_status_labels.name',
            'inventory_status_labels.success',
            'inventory_status_labels.color',
            'inventory_status_labels.created_at',
            'inventory_status_labels.updated_at',
            'inventory_status_labels.notes',
        ]);
        if ($request->filled('search')) {
            $statuslabels = $statuslabels->TextSearch($request->input('search'));
        }

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($statuslabels) && ($request->get('offset') > $statuslabels->count())) ? $statuslabels->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $statuslabels->orderBy($sort, $order);

        $total = $statuslabels->count();
        $statuslabels = $statuslabels->skip($offset)->take($limit)->get();
        return (new InventoryStatuslabelsTransformer)->transformInventoryStatuslabels($statuslabels, $total);
    }
}
