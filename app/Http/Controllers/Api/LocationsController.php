<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Location;
use App\Http\Transformers\LocationsTransformer;
use App\Http\Transformers\SelectlistTransformer;

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
                'id','name','address','address2','city','state','country','zip','created_at',
                'updated_at','manager_id','image',
                'assigned_assets_count','users_count','assets_count','currency'];

        $locations = Location::with('parent', 'manager', 'childLocations')->select([
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
            'locations.currency'
        ])->withCount('assignedAssets')
        ->withCount('assets')
        ->withCount('users');

        if ($request->has('search')) {
            $locations = $locations->TextSearch($request->input('search'));
        }



        $offset = (($locations) && (request('offset') > $locations->count())) ? 0 : request('offset', 0);
        $limit = $request->input('limit', 50);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Location::class);
        $location = new Location;
        $location->fill($request->all());

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
        $location = Location::with('parent', 'manager', 'childLocations')
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
                'locations.currency'
            ])
            ->withCount('assignedAssets')
            ->withCount('assets')
            ->withCount('users')->findOrFail($id);
        return (new LocationsTransformer)->transformLocation($location);
    }


    /**
     * Update the specified resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update', Location::class);
        $location = Location::findOrFail($id);
        $location->fill($request->all());

        if ($location->save()) {
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
        $this->authorize('delete', $location);
        $location->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/locations/message.delete.success')));
    }

    /**
     * Gets a paginated collection for the select2 menus
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0.16]
     * @see \App\Http\Transformers\SelectlistTransformer
     *
     */
    public function selectlist(Request $request)
    {

        $locations = Location::select([
            'locations.id',
            'locations.name',
            'locations.image',
        ]);

        if ($request->has('search')) {
            $locations = $locations->where('locations.name', 'LIKE', '%'.$request->get('search').'%');
        }

        $locations = $locations->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($locations as $location) {
            $location->use_text = $location->name;
            $location->use_image = ($location->image) ? url('/').'/uploads/locations/'.$location->image : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($locations);

    }

}
