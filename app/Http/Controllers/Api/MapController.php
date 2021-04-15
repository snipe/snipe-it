<?php


namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Location;
use App\Http\Transformers\LocationsTransformer;
use App\Http\Transformers\SelectlistTransformer;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class MapController extends Controller
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
        $this->authorize('view', Location::class);

        $locations = Location::with('assets')->select([
            'locations.id',
            'locations.name',
            'locations.address',
            'locations.coordinates',
        ])->withCount('assignedAssets as assigned_assets_count')
            ->withCount('assets as assets_count');

//        if ($request->filled('search')) {
//            $locations = $locations->TextSearch($request->input('search'));
//        }


        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
//        $offset = (($locations) && ($request->get('offset') > $locations->count())) ? $locations->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
//        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

//        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
//        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';

//        switch ($request->input('sort')) {
//            case 'parent':
//                $locations->OrderParent($order);
//                break;
//            case 'manager':
//                $locations->OrderManager($order);
//                break;
//            default:
//                $locations->orderBy($sort, $order);
//                break;
//        }


//        $total = $locations->count();
        $locations = $locations->get();
        return (new LocationsTransformer)->transformCollectionForMap($locations);
    }


}