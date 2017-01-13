<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Location;
use App\Http\Transformers\DatatablesTransformer;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Location::class);
        $locations = Location::all();
        return (new DatatablesTransformer)->transformDatatables($locations, count($locations));
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
            return response()->json(Helper::formatStandardApiResponse('success', $location, trans('admin/locations/message.create.success')));
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
        $location = Location::findOrFail($id);
        return $location;
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
        $this->authorize('edit', Location::class);
        $location = Location::findOrFail($id);
        $location->fill($request->all());

        if ($location->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $location, trans('admin/locations/message.update.success')));
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
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/locations/message.delete.success')));

    }
}
