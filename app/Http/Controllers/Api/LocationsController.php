<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Controllers\Controller;
use App\Http\Transformers\LocationsTransformer;
use App\Http\Transformers\SelectlistTransformer;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class LocationsController extends Controller
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
        $allowed_columns = [
            'id', 'name', 'address', 'address2', 'city', 'state', 'country', 'zip', 'created_at',
            'updated_at', 'manager_id', 'image',
            'assigned_assets_count', 'users_count', 'assets_count','assigned_assets_count', 'assets_count', 'rtd_assets_count', 'currency', 'ldap_ou', ];

        $locations = Location::with('parent', 'manager', 'children')->select([
            'locations.id',
            'locations.name',
            'locations.address',
            'locations.address2',
            'locations.city',
            'locations.state',
            'locations.zip',
            'locations.country',
            'locations.parent_id',
            'locations.manager_id',
            'locations.created_at',
            'locations.updated_at',
            'locations.image',
            'locations.ldap_ou',
            'locations.currency',
        ])->withCount('assignedAssets as assigned_assets_count')
            ->withCount('assets as assets_count')
            ->withCount('rtd_assets as rtd_assets_count')
            ->withCount('users as users_count');

        if ($request->filled('search')) {
            $locations = $locations->TextSearch($request->input('search'));
        }

        if ($request->filled('name')) {
            $locations->where('locations.name', '=', $request->input('name'));
        }

        if ($request->filled('address')) {
            $locations->where('locations.address', '=', $request->input('address'));
        }

        if ($request->filled('address2')) {
            $locations->where('locations.address2', '=', $request->input('address2'));
        }

        if ($request->filled('city')) {
            $locations->where('locations.city', '=', $request->input('city'));
        }

        if ($request->filled('zip')) {
            $locations->where('locations.zip', '=', $request->input('zip'));
        }

        if ($request->filled('country')) {
            $locations->where('locations.country', '=', $request->input('country'));
        }

        $offset = (($locations) && (request('offset') > $locations->count())) ? $locations->count() : request('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';

        switch ($request->input('sort')) {
            case 'parent':
                $locations->OrderParent($order);
                break;
            case 'manager':
                $locations->OrderManager($order);
                break;
            default:
                $locations->orderBy($sort, $order);
                break;
        }


        $total = $locations->count();
        $locations = $locations->skip($offset)->take($limit)->get();

        return (new LocationsTransformer)->transformLocations($locations, $total);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \App\Http\Requests\ImageUploadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Location::class);
        $location = new Location;
        $location->fill($request->all());
        $location = $request->handleImages($location);

        if ($location->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', (new LocationsTransformer)->transformLocation($location), trans('admin/locations/message.create.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $location->getErrors()));
    }

    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Location::class);
        $location = Location::with('parent', 'manager', 'children')
            ->select([
                'locations.id',
                'locations.name',
                'locations.address',
                'locations.address2',
                'locations.city',
                'locations.state',
                'locations.zip',
                'locations.country',
                'locations.parent_id',
                'locations.manager_id',
                'locations.created_at',
                'locations.updated_at',
                'locations.image',
                'locations.currency',
            ])
            ->withCount('assignedAssets as assigned_assets_count')
            ->withCount('assets as assets_count')
            ->withCount('rtd_assets as rtd_assets_count')
            ->withCount('users as users_count')
            ->findOrFail($id);

        return (new LocationsTransformer)->transformLocation($location);
    }


    /**
     * Update the specified resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \App\Http\Requests\ImageUploadRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ImageUploadRequest $request, $id)
    {
        $this->authorize('update', Location::class);
        $location = Location::findOrFail($id);

        $location->fill($request->all());
        $location = $request->handleImages($location);

        if ($location->isValid()) {

            $location->save();
            return response()->json(
                Helper::formatStandardApiResponse(
                    'success',
                    (new LocationsTransformer)->transformLocation($location),
                    trans('admin/locations/message.update.success')
                )
            );
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $location->getErrors()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Location::class);
        $location = Location::findOrFail($id);
        if (! $location->isDeletable()) {
            return response()
                    ->json(Helper::formatStandardApiResponse('error', null, trans('admin/companies/message.assoc_users')));
        }
        $this->authorize('delete', $location);
        $location->delete();

        return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/locations/message.delete.success')));
    }

    /**
     * Gets a paginated collection for the select2 menus
     *
     * This is handled slightly differently as of ~4.7.8-pre, as
     * we have to do some recursive magic to get the hierarchy to display
     * properly when looking at the parent/child relationship in the
     * rich menus.
     *
     * This means we can't use the normal pagination that we use elsewhere
     * in our selectlists, since we have to get the full set before we can
     * determine which location is parent/child/grandchild, etc.
     *
     * This also means that hierarchy display gets a little funky when people
     * use the Select2 search functionality, but there's not much we can do about
     * that right now.
     *
     * As a result, instead of paginating as part of the query, we have to grab
     * the entire data set, and then invoke a paginator manually and pass that
     * through to the SelectListTransformer.
     *
     * Many thanks to @uberbrady for the help getting this working better.
     * Recursion still sucks, but I guess he doesn't have to get in the
     * sea... this time.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0.16]
     * @see \App\Http\Transformers\SelectlistTransformer
     */
    public function selectlist(Request $request)
    {

        $this->authorize('view.selectlists');

        $locations = Location::select([
            'locations.id',
            'locations.name',
            'locations.parent_id',
            'locations.image',
        ]);

        $page = 1;
        if ($request->filled('page')) {
            $page = $request->input('page');
        }

        if ($request->filled('search')) {
            $locations = $locations->where('locations.name', 'LIKE', '%'.$request->input('search').'%');
        }

        $locations = $locations->orderBy('name', 'ASC')->get();

        $locations_with_children = [];

        foreach ($locations as $location) {
            if (! array_key_exists($location->parent_id, $locations_with_children)) {
                $locations_with_children[$location->parent_id] = [];
            }
            $locations_with_children[$location->parent_id][] = $location;
        }

        if ($request->filled('search')) {
            $locations_formatted = $locations;
        } else {
            $location_options = Location::indenter($locations_with_children);
            $locations_formatted = new Collection($location_options);
        }

        $paginated_results = new LengthAwarePaginator($locations_formatted->forPage($page, 500), $locations_formatted->count(), 500, $page, []);

        //return [];
        return (new SelectlistTransformer)->transformSelectlist($paginated_results);
    }
}
